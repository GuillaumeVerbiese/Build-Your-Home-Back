<?php

namespace App\Controller\Back;

use DateTime;
use App\Entity\Brand;
use App\Form\BrandType;
use App\Repository\BrandRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/back/brand")
 */
class BrandController extends AbstractController
{
    /**
     * @Route("/", name="app_back_brand_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $brands = $entityManager
            ->getRepository(Brand::class)
            ->findAll();

        return $this->render('back/brand/index.html.twig', [
            'brands' => $brands,
        ]);
    }

    /**
     * @Route("/new", name="app_back_brand_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $brand = new Brand();
        $brand->setCreatedAt(new DateTime()) ;
        $form = $this->createForm(BrandType::class, $brand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($brand);
            $entityManager->flush();

            return $this->redirectToRoute('app_back_brand_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/brand/new.html.twig', [
            'brand' => $brand,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_brand_show", methods={"GET"})
     */
    public function show(Brand $brand): Response
    {
        return $this->render('back/brand/show.html.twig', [
            'brand' => $brand,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_back_brand_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Brand $brand, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BrandType::class, $brand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $brand->setUpdatedAt(new DateTime()) ;
            $entityManager->flush();

            return $this->redirectToRoute('app_back_brand_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/brand/edit.html.twig', [
            'brand' => $brand,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_brand_delete", methods={"POST"})
     */
    public function delete(Request $request, Brand $brand, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$brand->getId(), $request->request->get('_token'))) {
            $entityManager->remove($brand);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_back_brand_index', [], Response::HTTP_SEE_OTHER);
    }
}
