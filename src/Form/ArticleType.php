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

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('price')
            ->add('stock')
            ->add('picture')
            ->add('rating')
            ->add('vat', EntityType::class, [
            'class' => VAT::class,
            'choice_label' => 'name',
            'multiple' => false, 
            'expanded' => false,
            ]
            )
            ->add('brand', EntityType::class, [
                'class' => Brand::class,
                'choice_label' => 'name',
                'multiple' => false, 
                'expanded' => false,
                ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => false, 
                'expanded' => false,
                ])
            ->add('discount', EntityType::class, [
                'class' => Discount::class,
                'choice_label' => 'name',
                'multiple' => false, 
                'expanded' => false,
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
