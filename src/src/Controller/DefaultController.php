<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{

    /**
     * @Route ("/hello/{name}")
     * @param string $name
     * @param LoggerInterface $logger
     * @return Response
     */
    public function index(string $name, LoggerInterface $logger): Response
    {
        $logger->info("Saying hello to $name!");

        return $this->render('default/index.html.twig', [
            'name' => $name,
        ]);
    }

    /**
     * @Route("/simplicity")
     * @return Response
     */
    public function simple(): Response
    {
        return new Response('Simple! Easy! Great!');
    }

    /**
     * @Route("/api/hello/{name}")
     */
    public function apiExample($name): JsonResponse
    {
        return $this->json([
                               'name' => $name,
                               'symfony' => 'rocks',
                           ]);
    }

    /**
     * @Route ("/showDebugInfo/")
     * @return JsonResponse
     */
    public function showDebugInfo(): JsonResponse
    {
        $projectRoot = $this->getParameter('kernel.project_dir');
        $info = file_get_contents($projectRoot . '/var/log/dev.log');
        return $this->json($info);
    }

}
