<?php

namespace App\Controller\Api;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    /**
     * @Route("/api/articles", name="app_api_browse_article", methods={"GET"})
     *  
     */
    public function browse(ArticleRepository $articleRepository): JsonResponse
    {
        $articles = $articleRepository->findAll();

        return $this->json(
            $articles,

            Response::HTTP_OK,
            [],
            [
                "groups" => [
                    "browse_article"
                ]
            ]
        );
    }

    /**
     * @Route("/api/article/{id}", name="app_api_read_article", methods={"GET"}, requirements={"id":"\d+"})
     *  
     */
    public function read(Article $article = null): JsonResponse
    {
        if ($article === null) {
            return $this->json(
                $article,
                Response::HTTP_NOT_FOUND
            );
        }
        return $this->json(
            $article,
            Response::HTTP_OK,
            [],
            [
                "groups" => [
                    "read_article"
                ]
            ]
        );
    }
}
