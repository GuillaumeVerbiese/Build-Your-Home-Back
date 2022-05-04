<?php

namespace App\Controller\Api;

use App\Entity\Brand;
use App\Repository\BrandRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BrandController extends AbstractController
{
    /**
     * @Route("/api/brands", name="app_api_browse_brand", methods={"GET"})
     *  
     */
    public function browse(BrandRepository $brandRepository): JsonResponse
    {
        $brands = $brandRepository->findAll();

        return $this->json(
            $brands,

            Response::HTTP_OK,
            [],
            [
                "groups" => [
                    "browse_brand"
                ]
            ]
        );
    }

    /**
     * @Route("/api/brand/{id}", name="app_api_read_brand", methods={"GET"}, requirements={"id":"\d+"})
     *  
     */
    public function read(Brand $brand = null): JsonResponse
    {
        if ($brand === null) {
            return $this->json(
                $brand,
                Response::HTTP_NOT_FOUND
            );
        }
        return $this->json(
            $brand,
            Response::HTTP_OK,
            [],
            [
                "groups" => [
                    "read_brand"
                ]
            ]
        );
    }
}
