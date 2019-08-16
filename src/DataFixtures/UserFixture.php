<?php

namespace App\DataFixtures;

use App\Entity\User;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
    //	$this->createMany(10, 'main_users', function($i) {

	      	$user = new User();
	        $user->setEmail('example@email.com'
	        	//, $i
	    );//);
	        $user->setPassword($this->passwordEncoder->encodePassword($user,'engage')); //passing $user so password encoder knows which encoder algorithm to use, passing word we want to use
	        $user->setFirstName("First Name");

	        return $user;

    //	});
	        $manager->flush();

    }
}
