<?php

namespace App\Controller\Api;

use App\Entity\Discount;
use App\Repository\DiscountRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DiscountController extends AbstractController
{
    /**
     * @Route("/api/discounts", name="app_api_browse_discount", methods={"GET"})
     *  
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
     * @Route("/api/discount/{id}", name="app_api_read_discount", methods={"GET"}, requirements={"id":"\d+"})
     *  
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
     * @Route("/api/discount/{id}/articles", name="app_api_read_discount_articles", methods={"GET"}, requirements={"id":"\d+"})
     *  
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
