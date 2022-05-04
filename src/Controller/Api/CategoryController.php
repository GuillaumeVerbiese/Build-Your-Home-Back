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

class CategoryController extends AbstractController
{
    /**
     * @Route("/api/categories", name="app_api_browse_category", methods={"GET"})
     *  
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
     * @Route("/api/category/{id}", name="app_api_read_category", methods={"GET"}, requirements={"id":"\d+"})
     *  
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
     * @Route("/api/category/{id}/articles", name="app_api_read_category_articles", methods={"GET"}, requirements={"id":"\d+"})
     *  
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
    /**
     * @Route("/api/category/{id}/articlesTest", name="app_api_read_category_articlesTest", methods={"GET"}, requirements={"id":"\d+"})
     *  
     */
    public function readByArticleTest(int $id, CategoryRepository $categoryrepo)
    {

        $category = $categoryrepo->find($id);
        
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
