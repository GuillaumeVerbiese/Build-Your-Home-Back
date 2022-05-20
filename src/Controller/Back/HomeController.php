<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_back_home")
     */
    public function index(): Response
    {
        if ($this->getUser()) {
            return $this->render('back/home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
        }

        return $this->redirectToRoute('app_login');
    }
}
