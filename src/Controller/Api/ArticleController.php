<?php

namespace App\Controller\Api;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenApi\Annotations as OA;

class ArticleController extends AbstractController
{
    /**
     * Renvoie la liste complètes des articles
     * 
     * @Route("/api/articles", name="app_api_browse_article", methods={"GET"})
     * 
     * 
     * @OA\Tag(name="article") 
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
     * Renvoie un article qui correspond à l'id
     * 
     * @Route("/api/article/{id}", name="app_api_read_article", methods={"GET"}, requirements={"id":"\d+"})
     * 
     * @OA\Tag(name="article") 
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
    /**
     * Renvoie les commentaires correspondant à l'article qui correspond à l'id
     * 
     * @Route("/api/comments/{id}/articles", name="app_api_read_article_comments", methods={"GET"}, requirements={"id":"\d+"})
     * 
     * @OA\Tag(name="article") 
     *  
     */
    public function readByComment(Article $article = null): JsonResponse
    {
        if ($article === null) {
            return $this->json(
                $article,
                Response::HTTP_NOT_FOUND
            );
        }
        return $this->json(
            $article->getComments(),
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
