<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\UserRegister;
use App\Entity\Users;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
     private UserPasswordEncoderInterface $passwordHasher;

     public function __construct(UserPasswordEncoderInterface $passwordHasher)
     {
         $this->passwordHasher = $passwordHasher;
     }

    public function load(ObjectManager $manager)
    {
        $user = new Users();
        $userRegister = new UserRegister();
        $plainPassword = 'test_pass';

        $encoded = $this->passwordHasher->encodePassword($user, $plainPassword);

        $userRegister->setPassword($encoded);

        $manager->persist($user);
        $manager->flush();
    }
}
