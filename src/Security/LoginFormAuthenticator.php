<?php

namespace App\Security;

use App\Repository\UserRepository;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{   
    private $userRepository;
    private $router;
    private $csrfTokenManager;
    private $passwordEncoder;

    public function __construct(UserRepository $userRepository, RouterInterface $router,CsrfTokenManagerInterface $csrfTokenManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->router = $router;         
        $this->csrfTokenManager = $csrfTokenManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    /* this f will be called on every req. It will return true if req contains auth info that this authenticator 
    knows how to process. Otherwise false will be returned */
    public function supports(Request $request)
    {
        // do your work when we're POSTing to the login page (check URL)
        return $request->attributes->get('_route') === 'app_login'
            && $request->isMethod('POST');

    }
    // will be called if supports() returns true 
    // getCredentials() will read auth creds (or token) off of the request and return them.
    public function getCredentials(Request $request)
    {
        return [
            'csrf_token' => $request->request->get('_csrf_token'),
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password'),
        ];

        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['email']
        );

        return $credentials;
    }
    // this will return User object, or null 
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $token = new CsrfToken('authenticate', $credentials['csrf_token']);

        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException();
        }

        return $this->userRepository->findOneBy(['email' => $credentials['email']]);
    }
    // if getUser returns User object this will be called and $credentials will be passed */
    public function checkCredentials($credentials, UserInterface $user)
    {
        // needed if we have password
        // if we would have API token system, there would not be a password
        // if we would return fales, user would see "Invalid creds" message
        return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return new RedirectResponse($this->router->generate('reservation'));
    }
    /* will be called on failure */
    protected function getLoginUrl()
    {
        return $this->router->generate('app_login');
    }

}
