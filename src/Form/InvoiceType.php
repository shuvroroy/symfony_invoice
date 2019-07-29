<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Invoice;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', null, [
                'disabled' => 'true'
             ])
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
            ->add('notes')
            ->add('sub_total', HiddenType::class)
            ->add('discount', null, [
                'attr' => [
                    'readonly' => 'readonly'
                ]
            ])
            ->add('total', HiddenType::class)
            ->add('po')
            ->add('deposit')
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'placeholder' => 'Choose a client',
                'choice_label' => function(Client $client) {
                    return sprintf('(%s) %s', $client->getPhone(), $client->getName());
                }
            ]);

        $builder->add('invoiceItems', CollectionType::class, [
            'entry_type' => InvoiceItemType::class,
            'allow_add' => true,
            'allow_delete' => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Invoice::class,
        ]);
    }
}
