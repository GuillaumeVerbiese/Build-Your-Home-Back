<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Brand;
use App\Entity\Order;
use App\Entity\OrderList;
use App\Entity\Article;
use App\Entity\DeliveriesFees;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('status')
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'firstname',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('deliveries', EntityType::class, [
                'class' => DeliveriesFees::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('orderlist', EntityType::class, [
                'class' => OrderList::class,
                'choice_label' => 'id',
                'multiple' => true,
                'expanded' => false,
            ])
            ->add('article', EntityType::class, [
                'class' => Article::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
