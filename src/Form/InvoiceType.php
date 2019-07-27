<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Invoice;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number')
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                // this is actually the default format for single_text
                'format' => 'yyyy-MM-dd',
            ])
            ->add('due_date', DateType::class, [
                'widget' => 'single_text',
                // this is actually the default format for single_text
                'format' => 'yyyy-MM-dd',
            ])
            ->add('notes', TextType::class)
            ->add('sub_total')
            ->add('discount')
            ->add('total')
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'placeholder' => 'Choose a client',
                'choice_label' => function(Client $client) {
                    return sprintf('(%s) %s', $client->getPhone(), $client->getName());
                }
            ])
            ->add('product', EntityType::class, [
                'mapped' => false,
                'class' => Product::class,
                'placeholder' => 'Choose a product',
                'choice_label' => function(Product $product) {
                    return sprintf('%s', $product->getName());
                }
            ])
            ->add('description', null, [
                'mapped' => false
            ])
            ->add('unit_price', null, [
                'mapped' => false
            ])
            ->add('qty', null, [
                'mapped' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Invoice::class,
        ]);
    }
}
