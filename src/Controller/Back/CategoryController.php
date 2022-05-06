<?php

namespace App\Controller\Back;

use DateTime;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/back/category")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="app_back_category_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $categories = $entityManager
            ->getRepository(Category::class)
            ->findAll();

        return $this->render('back/category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/new", name="app_back_category_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = new Category();
        $category->setCreatedAt(new DateTime()) ;
        $category->setDisplayOrder(0) ;
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {            
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('app_back_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/category/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_category_show", methods={"GET"})
     */
    public function show(Category $category): Response
    {
        return $this->render('back/category/show.html.twig', [
            'category' => $category,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_back_category_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category->setUpdatedAt(new DateTime()) ;
            $entityManager->flush();

            return $this->redirectToRoute('app_back_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_category_delete", methods={"POST"})
     */
    public function delete(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $entityManager->remove($category);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_back_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
