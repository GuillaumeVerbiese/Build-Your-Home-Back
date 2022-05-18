<?php

namespace App\EventSubscriber;

use App\Repository\ArticleRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Twig\Environment;

class CalcSubscriber implements EventSubscriberInterface
{
    private $articleRepository;
    private $twig;

    public function __construct(ArticleRepository $articleRepository, Environment $twig)
    {
        $this->articleRepository = $articleRepository;
        $this->twig = $twig;
    }

    public function onKernelController(ControllerEvent $event): void
    {
        // On récupére le tableau d'articles à commander
        $articlesList = $this->articleRepository->findEmptyStock();
        // On le donne à twig
        $this->twig->addGlobal("nbOfArticlesToOrder", count($articlesList));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.controller' => 'onKernelController',
        ];
    }
}
