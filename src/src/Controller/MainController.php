<?php

namespace App\Controller;

use App\Service\MessageGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/number")
     * @throws \Exception
     */
    public function number(): Response
    {
        $number = random_int(0, 100);

        return $this->render('number.html.twig', [
            'number' => $number,
        ]);
    }

    /**
     * @Route("/new")
     * @param \App\Service\MessageGenerator $messageGenerator
     */
    public function new(MessageGenerator $messageGenerator): Response
    {
        $message = $messageGenerator->getHappyMessage();
        $this->addFlash('success', $message);
        return $this->render('number.html.twig', [
            'number' => $message,
        ]);
    }
}