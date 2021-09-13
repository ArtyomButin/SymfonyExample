<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NavbarController extends AbstractController
{
    public function indexAction(Request $request):Response
    {
        $data = [
            'authorized' => true,
            'test' => 'test'
        ];
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $data['authorized'] = false;
        }
        return $this->render('inc/navbar.html.twig', [
            'data' => $data,
        ]);
    }
}
