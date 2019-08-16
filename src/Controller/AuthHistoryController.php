<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AuthHistoryController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/auth/history", name="auth_history")
     */
    public function index()
    {
    	//$this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('auth_history/index.html.twig', [
            'controller_name' => 'AuthHistoryController',
        ]);
    }
}
