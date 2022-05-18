<?php

namespace App\EventSubscriber;

use App\Repository\ArticleRepository;
use App\Repository\OrderRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Twig\Environment;

class CalcSubscriber implements EventSubscriberInterface
{
    private $orderRepository;
    private $articleRepository;
    private $twig;

    public function __construct(ArticleRepository $articleRepository, Environment $twig, OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->articleRepository = $articleRepository;
        $this->twig = $twig;
    }

    public function onKernelController(ControllerEvent $event): void
    {
        // On récupére le tableau d'articles à commander
        $articlesList = $this->articleRepository->findEmptyStock();
        // On donne la longueur du tableau à twig
        $this->twig->addGlobal("nbOfArticlesToOrder", count($articlesList));

        // On récupére le tableau de commandes en attente
        $pendingOrders = $this->orderRepository->findBy(["status"=>0]);
        // On donne la longueur du tableau à twig
        $this->twig->addGlobal("nbOfPendingOrders", count($pendingOrders));

        // On récupére le tableau de commandes en attente
        $validateOrders = $this->orderRepository->findBy(["status"=>1]);
        // On donne la longueur du tableau à twig
        $this->twig->addGlobal("nbOfValidateOrders", count($validateOrders));

        // On récupére le tableau de commandes en attente
        $pendingStockOrders = $this->orderRepository->findBy(["status"=>2]);
        // On donne la longueur du tableau à twig
        $this->twig->addGlobal("nbOfPendingStockOrders", count($pendingStockOrders));

        // On récupére le tableau de commandes en attente
        $ordersShipped = $this->orderRepository->findBy(["status"=>3]);
        // On donne la longueur du tableau à twig
        $this->twig->addGlobal("nbOfOrdersShipped", count($ordersShipped));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.controller' => 'onKernelController',
        ];
    }
}
