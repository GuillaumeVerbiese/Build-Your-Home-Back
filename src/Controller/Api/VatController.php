<?php

namespace App\Controller\Api;

use App\Entity\VAT;
use App\Repository\VATRepository;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Annotations as OA;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @OA\Tag(name="VAT")
 */
class VatController extends AbstractController
{
    /**
     * Renvoie la liste des taux de TVA
     * 
     * @Route("/api/vats", name="app_api_browse_vat", methods={"GET"})
     *  
     */
    public function browse(VATRepository $vatRepository): JsonResponse
    {
        $vats = $vatRepository->findAll();

        return $this->json(
            $vats,

            Response::HTTP_OK,
            [],
            [
                "groups" => [
                    "browse_vat"
                ]
            ]
        );
    }

    /**
     * Renvoie le taux de TVA correspondant à l'id
     * 
     * @Route("/api/vat/{id}", name="app_api_read_vat", methods={"GET"}, requirements={"id":"\d+"})
     *  
     */
    public function read(VAT $vat = null): JsonResponse
    {
        if ($vat === null) {
            return $this->json(
                $vat,
                Response::HTTP_NOT_FOUND
            );
        }
        return $this->json(
            $vat,
            Response::HTTP_OK,
            [],
            [
                "groups" => [
                    "read_vat"
                ]
            ]
        );
    }
}
