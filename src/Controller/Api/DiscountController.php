<?php

namespace App\Controller\Api;

use App\Entity\Discount;
use App\Repository\DiscountRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenApi\Annotations as OA;

class DiscountController extends AbstractController
{
    /**
     * Renvoie la liste des réductions
     * 
     * @Route("/api/discounts", name="app_api_browse_discount", methods={"GET"})
     *  
     * @OA\Tag(name="discount")
     */
    public function browse(DiscountRepository $discountRepository): JsonResponse
    {
        $discounts = $discountRepository->findAll();

        return $this->json(
            $discounts,

            Response::HTTP_OK,
            [],
            [
                "groups" => [
                    "browse_discount"
                ]
            ]
        );
    }

    /**
     * Renvoie la réduction correspond à l'id
     * 
     * @Route("/api/discount/{id}", name="app_api_read_discount", methods={"GET"}, requirements={"id":"\d+"})
     *  
     * @OA\Tag(name="discount")
     */
    public function read(Discount $discount = null): JsonResponse
    {
        if ($discount === null) {
            return $this->json(
                $discount,
                Response::HTTP_NOT_FOUND
            );
        }
        return $this->json(
            $discount,
            Response::HTTP_OK,
            [],
            [
                "groups" => [
                    "read_discount"
                ]
            ]
        );
    }
    /**
     * Renvoie la liste des articles dont la réduction correspond à l'id
     * 
     * @Route("/api/discount/{id}/articles", name="app_api_read_discount_articles", methods={"GET"}, requirements={"id":"\d+"})
     * 
     * 
     * @OA\Tag(name="discount") 
     */
    public function readByArticle(Discount $discount = null)
    {
        if ($discount === null) {
            return $this->json(
                $discount,
                Response::HTTP_NOT_FOUND
            );
        }
        return $this->json(
            $discount->getArticles(),
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
