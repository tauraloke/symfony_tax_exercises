<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Repository\ProductRepository;
use App\Entity\Product;

class CartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('vatin', TextType::class, ['label'=>'Your TAX number'])
            ->add('cart', ChoiceType::class, [
                'required' => false,
                'multiple' => true,
                'choices'  => ProductRepository::getAll(),
                'choice_value' => function (?Product $product) {
                    return $product ? $product->getId() : 'none';
                },
                'choice_label' => function (?Product $product) {
                    return $product ? "{$product->getTitle()} - {$product->getCurrency()}{$product->getPrice()}" : '';
                },
            ])
            ->add('Send', SubmitType::class);
    }
}