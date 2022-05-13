<?php

namespace App\Form;

use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderManagementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // On ajoute un écouteur d'événement sur le formulaire
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            // On peut donc récupérer la commande concernée par le formulaire
            $order = $event->getData();
            // On récupére le formulaire
            $form = $event->getForm();
            // On lui ajoute les champs comme avec le builder
            $form
                ->add('status', ChoiceType::class, [
                "label" => "Passer l'état de la commande à :",
                'choices'  => [
                    'en attente' => 0,
                    'validée' => 1,
                    'expédiée' => 2,
                    'archivée' => 3
                ],
                "multiple" => false,
                "expanded" => true,
                // Grace à data on peut spécifier la valeur par défaut du champs, ici, le statut de la commande
                'data' => $order->getStatus() ? $order->getStatus() : 0
                ])
                ->add('sauvegarder', SubmitType::class);
        })
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
