<?php

namespace App\Controller;

use App\Service\MessageGenerator;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/")
     * @throws Exception
     */
    public function menu(Request $request): Response
    {
        return $this->render('default/index.html.twig', [
        ]);
    }

}
