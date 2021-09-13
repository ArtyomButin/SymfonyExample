<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class ProductsAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form->add('Name', TextType::class, [
            'attr' => ['class' => 'form-control']
        ])
            ->add('Price', MoneyType::class, [
                'required' => 0.0,
                'divisor' => 100,
                'currency' => 'RUB',
                'html5' => true,
                'attr' => ['class' => 'form-control']
            ])
            ->add('Description', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('Photo', FileType::class, [
                'required' => false,
                'data_class' => null,
                'empty_data' => "empty",
                'label' => 'Product Photo',
                'attr' => ['class' => 'form-control-file'],
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter->add('Name')
            ->add('Price')
            ->add('Description')
            ->add('Photo');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list->addIdentifier('Name')
            ->addIdentifier('Price')
            ->addIdentifier('Description')
            ->addIdentifier('Photo');
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('Name')
            ->add('Price')
            ->add('Description')
            ->add('Photo');
    }
}
