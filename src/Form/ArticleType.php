<?php

namespace App\Form;

use App\Entity\VAT;
use App\Entity\Brand;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Discount;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,
            [
                "label" => "Nom :",
            ])
            ->add('description', TextType::class,
            [
                "label" => "Description :",
            ])
            ->add('price', IntegerType::class,
            [
                "label" => "Prix :",
            ])
            ->add('stock', IntegerType::class,
            [
                "label" => "Stock :",
            ])
            ->add('picture', TextType::class,
            [
                "label" => "Image :",
            ])
            ->add('rating', NumberType::class,
            [
                "label" => "Note :",
            ])
            ->add('vat', EntityType::class, [
            'class' => VAT::class,
            'choice_label' => 'name',
            'multiple' => false, 
            'expanded' => false,
            'label' => "TVA :"
            ]
            )
            ->add('brand', EntityType::class, [
                'class' => Brand::class,
                'choice_label' => 'name',
                'multiple' => false, 
                'expanded' => false,
                'label' => "Marque :"
                ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => false, 
                'expanded' => false,
                'label' => "Catégorie :"
                ])
            ->add('discount', EntityType::class, [
                'class' => Discount::class,
                'choice_label' => 'name',
                'multiple' => false, 
                'expanded' => false,
                'label' => "Réduction :"
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
