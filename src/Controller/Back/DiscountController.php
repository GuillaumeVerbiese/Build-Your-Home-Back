<?php

namespace App\Controller\Back;

use DateTime;
use App\Entity\Discount;
use App\Form\DiscountType;
use App\Repository\DiscountRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/back/discount")
 */
class DiscountController extends AbstractController
{
    /**
     * @Route("/", name="app_back_discount_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $discounts = $entityManager
            ->getRepository(Discount::class)
            ->findAll();

        return $this->render('back/discount/index.html.twig', [
            'discounts' => $discounts,
        ]);
    }

    /**
     * @Route("/new", name="app_back_discount_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $discount = new Discount();
        $discount->setCreatedAt(new DateTime()) ;
        $form = $this->createForm(DiscountType::class, $discount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($discount);
            $entityManager->flush();

            return $this->redirectToRoute('app_back_discount_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/discount/new.html.twig', [
            'discount' => $discount,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_discount_show", methods={"GET"})
     */
    public function show(Discount $discount): Response
    {
        return $this->render('back/discount/show.html.twig', [
            'discount' => $discount,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_back_discount_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Discount $discount, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DiscountType::class, $discount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $discount->setUpdatedAt(new DateTime()) ;
            $entityManager->flush();

            return $this->redirectToRoute('app_back_discount_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/discount/edit.html.twig', [
            'discount' => $discount,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_discount_delete", methods={"POST"})
     */
    public function delete(Request $request, Discount $discount, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$discount->getId(), $request->request->get('_token'))) {
            $entityManager->remove($discount);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_back_discount_index', [], Response::HTTP_SEE_OTHER);
    }
}
