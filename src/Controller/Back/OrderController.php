<?php

namespace App\Controller\Back;

use App\Entity\Order;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/back/order")
 */
class OrderController extends AbstractController
{
    /**
     * @Route("/", name="app_back_order_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $orders = $entityManager
            ->getRepository(Order::class)
            ->findAll();

        return $this->render('back/order/index.html.twig', [
            'orders' => $orders,
        ]);
    }

    

    /**
     * @Route("/{id}", name="app_back_order_show", methods={"GET"})
     */
    public function show(Order $order): Response
    {
        return $this->render('back/order/show.html.twig', [
            'order' => $order,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_back_order_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Order $order, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Votre commande a bien été modifier.'
            );

            return $this->redirectToRoute('app_back_order_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/order/edit.html.twig', [
            'order' => $order,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_order_delete", methods={"POST"})
     */
    public function delete(Request $request, Order $order, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
            $entityManager->remove($order);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Votre commande a bien été supprimer.'
            );
        }

        return $this->redirectToRoute('app_back_order_index', [], Response::HTTP_SEE_OTHER);
    }
}
