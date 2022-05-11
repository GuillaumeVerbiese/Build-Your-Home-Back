<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Article;
use App\Entity\Favorite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FavoriteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false, 
                'documentation' => [
                    'type' => 'integer',
                    'description' => 'id de l\'utilisateur'
                ],
            ])
            ->add('article', EntityType::class, [
                'class' => Article::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false,
                'documentation' => [
                    'type' => 'integer',
                    'description' => 'id d\'article'
                ],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Favorite::class,
        ]);
    }
}
