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
        $data = [
            'authorized' => false,
            'test' => 'test'
        ];
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $data['authorized'] = false;
        }
        return $this->render('default/index.html.twig', [
            'data' => $data,
        ]);
    }

}
