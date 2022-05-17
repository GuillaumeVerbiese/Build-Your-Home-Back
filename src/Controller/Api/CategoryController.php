<?php

namespace App\Controller\Api;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenApi\Annotations as OA;

class CategoryController extends AbstractController
{
    /**
     * Renvoie la liste des catégories
     * 
     * @Route("/api/categories", name="app_api_browse_category", methods={"GET"})
     *  
     * @OA\Tag(name="category")
     */
    public function browse(CategoryRepository $categoryRepository): JsonResponse
    {
        $categories = $categoryRepository->findAll();

        return $this->json(
            $categories,

            Response::HTTP_OK,
            [],
            [
                "groups" => [
                    "browse_category"
                ]
            ]
        );
    }

    /**
     * Renvoie la catégorie qui correspond à l'id
     * 
     * @Route("/api/category/{id}", name="app_api_read_category", methods={"GET"}, requirements={"id":"\d+"})
     *  
     * @OA\Tag(name="category")
     */
    public function read(Category $category = null): JsonResponse
    {
        if ($category === null) {
            return $this->json(
                $category,
                Response::HTTP_NOT_FOUND
            );
        }
        return $this->json(
            $category,
            Response::HTTP_OK,
            [],
            [
                "groups" => [
                    "read_category"
                ]
            ]
        );
    }

    /**
     * Renvoie la liste des articles de la catégorie qui correspond à l'id
     * 
     * @Route("/api/category/{id}/articles", name="app_api_read_category_articles", methods={"GET"}, requirements={"id":"\d+"})
     *  
     * @OA\Tag(name="category")
     */
    public function readByArticle(Category $category = null)
    {
        if ($category === null) {
            return $this->json(
                $category,
                Response::HTTP_NOT_FOUND
            );
        }
        return $this->json(
            $category->getArticles(),
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
