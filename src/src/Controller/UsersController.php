<?php

declare(strict_types=1);

namespace App\Controller;

use App\DBAL\Types\GenderType;
use App\Entity\Users;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    /**
     * @Route ("/users")
     * @param Connection $connection
     * @return Response
     */
    public function index(Connection $connection): Response
    {
        return $this->render('users/index.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }

    /**
     * @Route ("/users/new")
     */
    public function createNewUser(EntityManagerInterface $entityManager): Response
    {
        $user = new Users();
        $user->setName('John')
            ->setLastName('Smith')
            ->setEmail('john@example.com')
            ->setPhone('+333333333')
            ->setAge(20)
            ->setGender(GenderType::MAN);
        $entityManager->persist($user);
        $entityManager->flush();
        return new Response(sprintf("Created new user %s", $user->getName()));
    }
}
