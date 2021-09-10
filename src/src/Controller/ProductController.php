<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'product', schemes: ['http'])]
    public function index(RequestStack $request_stack ,ProductRepository $productRepository): Response
    {
        $products = $productRepository
            ->findAll();
        if (!$products) {
            throw $this->createNotFoundException(
                'products not found'
            );
        }

        foreach ($products as $product) {
            $product->url = $this->generateUrl('product_show', [
                'id' => $product->getId(),
            ]);
        }
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
            'products' => $products,
        ]);
    }

    /**
     * @Route("/product/new", name="create_product")
     * @throws Exception
     **/
    public function createProduct(ValidatorInterface $validator): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = new Product();
        $product->setName('PC Mouse')
            ->setPrice(random_int(1990, 2021))
            ->setDescription('Ergonomic and stylish!');
        $errors = $validator->validate($product);
        if (count($errors) > 0) {
            return new Response((string)$errors, 400);
        } else {
            $entityManager->persist($product);
            $entityManager->flush();
            return new Response('Saved new product with id ' . $product->getId());
        }
    }

    /**
     * @Route("/product/{id}", name="product_show", requirements={"id"="\d+"})
     * @ParamConverter("product", class="ProductRepository::class")
     * @param int $id
     * @param ProductRepository $productRepository
     * @return Response
     */
    public function showProduct(int $id, ProductRepository $productRepository): Response
    {

        $product = $productRepository
            ->find($id);
        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
            'product' => $product
        ]);
    }
}
