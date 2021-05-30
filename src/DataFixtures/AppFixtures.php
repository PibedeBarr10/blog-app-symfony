<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
		//$pass = "123";
		
        //$admin = new User();
		//$admin->setEmail("admin@email.com");
		//$admin->setPassword(
		//	$passwordEncoder->encodePassword($admin, $pass)
		//);
		//$admin->setUsername("Admin");
		//$admin->setRoles(['ROLE_USER']);
        //$manager->persist($admin);

        //$manager->flush();
    }
}
