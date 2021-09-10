<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;

use App\Service\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Exception;
use Psr\Log\LoggerInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType,
    Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProductController extends AbstractController
{
    /**
     * @Route("/products", name="products_list", schemes={"http"})
     * @param RequestStack $request_stack
     * @param ProductRepository $productRepository
     * @param LoggerInterface $logger
     * @return Response
     */
    public function index(
        RequestStack $request_stack,
        ProductRepository $productRepository,
        LoggerInterface $logger
    ): Response {
        $products = $productRepository
            ->findAll();
        if (!$products) {
            $logger->error('products not found');
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
            'products' => $products,
        ]);
    }

    /**
     * @Route("/product/new", name="create_product", methods={"GET", "POST"})
     * @throws Exception
     **/
    public function createProduct(Request $request, LoggerInterface $logger, FileUploader $fileUploader): Response
    {
        $product = new Product();
        $form = $this->createFormBuilder($product)
            ->add('Name', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('Price', TextType::class, [
                'required' => 0.0,
                'attr' => ['class' => 'form-control']
            ])
            ->add('Description', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('Photo', FileType::class, [
                'required' => false,
                'label' => 'Product Photo',
                'attr' => ['class' => 'form-control-file'],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Create',
                'attr' => ['class' => 'btn btn-primary mt-3'],
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();

            $photo = $form->get('Photo')->getData();
            if($photo) {
                $photoFileName = $fileUploader->upload($photo);
                $product->setPhoto($photoFileName);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();
            return $this->redirectToRoute('products_list');
        }
        return $this->render(
            'product/create.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/product/{id}", name="product_show", requirements={"id"="\d+"})
     * @ParamConverter("product", options={"id" = "id"})
     * @param int $id
     * @param Product $product
     * @param FileUploader $uploader
     * @return Response
     */
    public function showProduct(int $id, Product $product ,FileUploader $uploader): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
            'redirectToList' => $this->generateUrl('products_list')
        ]);
    }

    /**
     * @Route("/product/delete/{id}", requirements={"id"="\d+"}, methods={"DELETE"})
     * @param Request $request
     * @param $id
     */
    public function deleteProduct(Request $request, $id)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($product);
        $entityManager->flush();

        $response = new Response();
        $response->send();
    }

    /**
     * @Route("/product/edit/{id}", name="edit_product", methods={"GET", "POST"})
     * @ParamConverter("product", options={"id" = "id"})
     * @param Request $request
     * @param Product $product
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function editProduct(Request $request, Product $product, FileUploader $fileUploader): Response
    {
        $form = $this->createFormBuilder($product)
            ->add('Name', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('Price', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('Description', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('Photo', FileType::class, [
                'required' => false,
                'data_class' => null,
                'label' => 'Product Photo',
                'attr' => ['class' => 'form-control-file'],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Edit',
                'attr' => ['class' => 'btn btn-primary mt-3'],
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photo = $form->get('Photo')->getData();
            if($photo) {
                $photoFileName = $fileUploader->upload($photo);
                $product->setPhoto($photoFileName);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('products_list');
        }
        return $this->render(
            'product/create.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}

