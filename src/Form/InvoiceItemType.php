<?php

namespace App\Form;

use App\Entity\InvoiceItem;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoiceItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('unit_price', null, [
                'disabled' => 'true'
            ])
            ->add('qty')
            ->add('description', TextareaType::class, [
                'mapped' => false,
                'disabled' => true,

            ])
            ->add('lineTotal', null, [
                'mapped' => false,
                'disabled' => true
            ])
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'attr' => [
                    'data-id' => '__name__'
                ],
                'placeholder' => 'Choose a product',
                'choice_label' => function(Product $product) {
                    return sprintf('%s', $product->getName());
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => InvoiceItem::class,
        ]);
    }
}
