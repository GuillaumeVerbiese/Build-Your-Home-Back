<?php

namespace App\Controller\Api;

use App\Entity\Brand;
use App\Repository\BrandRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenApi\Annotations as OA;

class BrandController extends AbstractController
{
    /**
     * Renvoie l'ensemble des marques
     * 
     * @Route("/api/brands", name="app_api_browse_brand", methods={"GET"})
     *  
     * @OA\Tag(name="brand") 
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
     * Renvoi la marque qui correspond à l'id
     * 
     * @Route("/api/brand/{id}", name="app_api_read_brand", methods={"GET"}, requirements={"id":"\d+"})
     *  
     * @OA\Tag(name="brand")
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
    /**
     * Renvoi la liste des articles qui appartiennent à la marque fourni en id
     * 
     * @Route("/api/brand/{id}/articles", name="app_api_read_brand_articles", methods={"GET"}, requirements={"id":"\d+"})
     *  
     * 
     * @OA\Tag(name="brand")
     */
    public function readByArticle(Brand $brand = null)
    {
        if ($brand === null) {
            return $this->json(
                $brand,
                Response::HTTP_NOT_FOUND
            );
        }
        return $this->json(
            $brand->getArticles(),
            Response::HTTP_OK,
            [],
            [
                "groups" => [
                    "read_category_article"
                ]
            ]
        );
    }
}
