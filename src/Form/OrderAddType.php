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

        //{
//   "status": 0,
//   "user": 7,
//   "deliveries": 11,
//   "article": [
//     223,224
//   ]
// }
            ->add('status')
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'firstname',
                'multiple' => false,
                'expanded' => false, 
                'documentation' => [
                    'type' => 'integer',
                    'description' => 'id de l\'utilisateur'
                ],
            ])
            ->add('deliveries', EntityType::class, [
                'class' => DeliveriesFees::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'documentation' => [
                    'type' => 'integer',
                    'description' => 'id des frais de livraison'
                ],
            ])
            ->add('article', EntityType::class, [
                'class' => Article::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false,
                'documentation' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'integer'
                    ],
                    'description' => 'tableau d\'id d\'article'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
