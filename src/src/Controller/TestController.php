<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'test')]
    public function index(): Response
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }

    /**
     * @throws \Psr\Cache\InvalidArgumentException
     */
    #[Route('/test/getData', name: 'getData')]
    public function testData()
    {
        $cache = new FilesystemAdapter();
        $cache->get();
        $productCache = $cache->getItem('new.cache.item');
        $productCache->set();
        dump($cache);
//        $request = Request::create(
//            '/testData',
//            'GET',
//            array('name' => 'Test')
//        );
//        $acceptHeader = AcceptHeader::fromString($request->headers->get('Accept'));
//        dump($acceptHeader);
//        $response = new Response(
//            'TestContent',
//            Response::HTTP_OK,
//            ['content-type' => 'text/html']
//        );
//        $response->setStatusCode(Response::HTTP_NOT_FOUND);
//        $response->setCharset('ISO-8859-1');
//        $response->headers->setCookie(Cookie::create('foo')
//            ->withValue('bar')
//            ->withExpires(strtotime('Fri, 20-May-2011 15:25:52 GMT'))
//            ->withDomain('.example.com')
//            ->withSecure(true));
//        dump($response);
//        $response->send();
        $responseCallback = function () {
            dump('Hello World');
            flush();
            sleep(2);
            dump('Hello World');
            flush();
        };
        $response = new StreamedResponse();
        $response->setCallback($responseCallback);
        $response->send();
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
}
