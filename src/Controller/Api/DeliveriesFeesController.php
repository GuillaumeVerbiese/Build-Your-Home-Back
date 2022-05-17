<?php

namespace App\Controller\Api;

use App\Entity\DeliveriesFees;
use App\Repository\DeliveriesFeesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenApi\Annotations as OA;

class DeliveriesFeesController extends AbstractController
{
    /**
     * Renvoie la liste des frais de livraison
     * 
     * @Route("/api/deliveryfees", name="app_api_browse_deliveryfee", methods={"GET"})
     *  
     * @OA\Tag(name="deliveriesFees")
     */
    public function browse(DeliveriesFeesRepository $deliveryfeeRepository): JsonResponse
    {
        $deliveryfees = $deliveryfeeRepository->findAll();

        return $this->json(
            $deliveryfees,

            Response::HTTP_OK,
            [],
            [
                "groups" => [
                    "browse_deliveryfee"
                ]
            ]
        );
    }

    /**
     * Renvoie les frais de livraison correspondant à l'id
     * 
     * @Route("/api/deliveriesfee/{id}", name="app_api_read_deliveriesfee", methods={"GET"}, requirements={"id":"\d+"})
     *  
     * @OA\Tag(name="deliveriesFees")
     */
    public function read(DeliveriesFees $deliveriesfee = null): JsonResponse
    {
        if ($deliveriesfee === null) {
            return $this->json(
                $deliveriesfee,
                Response::HTTP_NOT_FOUND
            );
        }
        return $this->json(
            $deliveriesfee,
            Response::HTTP_OK,
            [],
            [
                "groups" => [
                    "read_deliveriesfee"
                ]
            ]
        );
    }
    /**
     * Renvoie la liste des articles avec des frais de livraison qui correspondent à l'id
     * 
     * @Route("/api/deliveryfee/{id}/orders", name="app_api_read_deliveryfee_orders", methods={"GET"}, requirements={"id":"\d+"})
     *  
     * @OA\Tag(name="deliveriesFees")
     */
    public function readByArticle(DeliveriesFees $deliveryfee = null)
    {
        if ($deliveryfee === null) {
            return $this->json(
                $deliveryfee,
                Response::HTTP_NOT_FOUND
            );
        }
        return $this->json(
            $deliveryfee->getOrders(),
            Response::HTTP_OK,
            [],
            [
                "groups" => [
                    "read_order",
                    
                ]
            ]
        );
    }
}
