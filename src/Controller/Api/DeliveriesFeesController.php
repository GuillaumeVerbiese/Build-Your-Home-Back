<?php

namespace App\Controller\Api;

use App\Entity\DeliveriesFees;
use App\Repository\DeliveriesFeesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeliveriesFeesController extends AbstractController
{
    /**
     * @Route("/api/deliveryfees", name="app_api_browse_deliveryfee", methods={"GET"})
     *  
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
     * @Route("/api/deliveriesfee/{id}", name="app_api_read_deliveriesfee", methods={"GET"}, requirements={"id":"\d+"})
     *  
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
}
