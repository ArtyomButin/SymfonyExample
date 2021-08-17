<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Users;
use Doctrine\DBAL\Driver\Connection;
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
        $users = $connection->exec('SELECT * FROM users');

        return $this->render('users/index.html.twig', [
            'controller_name' => 'UsersController',
            'users_data' => $users,
        ]);
    }

    public function createNewUser(User $user): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = new User();
    }
}
