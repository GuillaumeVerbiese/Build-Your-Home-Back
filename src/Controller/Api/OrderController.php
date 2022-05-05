<?php

namespace App\Controller\Api;

use App\Entity\Order;
use App\Repository\UserRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    /**
     * @Route("/api/orders", name="app_api_browse_order", methods={"GET"})
     *  
     */
    public function browse(OrderRepository $orderRepository): JsonResponse
    {
        $orders = $orderRepository->findAll();

        return $this->json(
            $orders,

            Response::HTTP_OK,
            [],
            [
                "groups" => [
                    "browse_order"
                ]
            ]
        );
    }

    /**
     * @Route("/api/order/{id}", name="app_api_read_order", methods={"GET"}, requirements={"id":"\d+"})
     *  
     */
    public function read(Order $order = null): JsonResponse
    {
        if ($order === null) {
            return $this->json(
                $order,
                Response::HTTP_NOT_FOUND
            );
        }
        return $this->json(
            $order,
            Response::HTTP_OK,
            [],
            [
                "groups" => [
                    "read_order"
                ]
            ]
        );
    }

    /**
     * @Route("/api/orders/{id}/status", name="app_api_read_order_status", methods={"GET"}, requirements={"id":"\d+"})
     *  
     */
    public function readByStatus(int $id, OrderRepository $orderRepository): JsonResponse
    {
        $orders = $orderRepository->findAllByStatus($id);

        return $this->json(
            $orders,

            Response::HTTP_OK,
            [],
            [
                "groups" => [
                    "browse_order"
                ]
            ]
        );
    }

   
}
