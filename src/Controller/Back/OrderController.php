<?php

namespace App\Controller\Back;

use App\Entity\Order;
use App\Form\OrderManagementType;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use DateTime;
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

    /**
     * @Route("/management/{status}", name="app_back_order_management", methods={"GET"}, requirements={"status":"[0-3]"})
     */
    public function orderManagement(int $status, OrderRepository $orderRepository): Response
    {
        // On récupère les commandes par rapport au status récupéré dans l'url
        $orders = $orderRepository->findBy(["status"=>$status],["createdAt" => "ASC"]);
        // on crée une liste avec les status compréhensible par l'utilisateur (indexé dans le bon ordre)
        $statusList = ["en attentes","validées","expédiées","archivées"];
        // On renvoie le bon template avec les bonnes données
        return $this->render('back/order_management/index.html.twig', [
            'orders' => $orders,
            'status' => $statusList[$status]
        ]);
    }

    /**
     * @Route("/management/show/{id}", name="app_back_order_management_show", methods={"GET", "POST"}, requirements={"id":"\d+"})
     */
    public function showOrderManagement(Request $request, Order $order, EntityManagerInterface $entityManager): Response
    {
        $statusList = ["en attentes","validées","expédiées","archivées"];
        $form = $this->createForm(OrderManagementType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $order->setUpdatedAt(new DateTime());
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Votre commande a bien été modifier.'
            );

            return $this->redirectToRoute('app_back_order_management', ["status"=>$order->getStatus()], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('back/order_management/show.html.twig', [
            'order' => $order,
            'form' => $form,
            'status' => $statusList
        ]);
    }
}
