<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('photo', FileType::class, [
                'label' => 'Photo (Png file)',

                // не отображенное означает, что это поле не ассоциировано ни с одним свойством сущности
                'mapped' => false,

                // сделайте его необязательным, чтобы вам не нужно было повторно загружать PDF-файл
                // каждый раз, когда будете редактировать детали Product
                'required' => false,

                // не отображенные поля не могут определять свою валидацию используя аннотации
                // в ассоциированной сущности, поэтому вы можете использовать ограничительные классы PHP
                'constraints' => [
                    new File([
                                 'maxSize' => '1024k',
                                 'mimeTypes' => [
                                     'application/png',
                                     'application/jpg',
                                     'application/jpeg',
                                 ],
                                 'mimeTypesMessage' => 'Please upload a valid format (jpg, jpeg, png)',
                             ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
                                   'data_class' => Product::class,
                               ]);
    }
}
