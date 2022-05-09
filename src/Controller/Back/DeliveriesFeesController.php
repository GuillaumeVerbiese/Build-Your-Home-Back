<?php

namespace App\Controller\Back;

use DateTime;
use App\Entity\DeliveriesFees;
use App\Form\DeliveriesFeesType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DeliveriesFeesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/back/deliveriesfees")
 */
class DeliveriesFeesController extends AbstractController
{
    /**
     * @Route("/", name="app_back_deliveries_fees_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $deliveriesFees = $entityManager
            ->getRepository(DeliveriesFees::class)
            ->findAll();

        return $this->render('back/deliveries_fees/index.html.twig', [
            'deliveries_fees' => $deliveriesFees,
        ]);
    }

    /**
     * @Route("/new", name="app_back_deliveries_fees_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $deliveriesFee = new DeliveriesFees();
        $deliveriesFee->setCreatedAt(new DateTime()) ;
        $form = $this->createForm(DeliveriesFeesType::class, $deliveriesFee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($deliveriesFee);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Votre frais de livraison a bien été ajouter.'
            );

            return $this->redirectToRoute('app_back_deliveries_fees_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/deliveries_fees/new.html.twig', [
            'deliveries_fee' => $deliveriesFee,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_deliveries_fees_show", methods={"GET"})
     */
    public function show(DeliveriesFees $deliveriesFee): Response
    {
        return $this->render('back/deliveries_fees/show.html.twig', [
            'deliveries_fee' => $deliveriesFee,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_back_deliveries_fees_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, DeliveriesFees $deliveriesFee, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DeliveriesFeesType::class, $deliveriesFee);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $deliveriesFee->setUpdatedAt(new DateTime()) ;
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Votre frais de livraison a bien été modifier.'
            );

            return $this->redirectToRoute('app_back_deliveries_fees_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/deliveries_fees/edit.html.twig', [
            'deliveries_fee' => $deliveriesFee,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_deliveries_fees_delete", methods={"POST"})
     */
    public function delete(Request $request, DeliveriesFees $deliveriesFee, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$deliveriesFee->getId(), $request->request->get('_token'))) {
            $entityManager->remove($deliveriesFee);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Votre frais de livraison a bien été supprimer.'
            );
        }

        return $this->redirectToRoute('app_back_deliveries_fees_index', [], Response::HTTP_SEE_OTHER);
    }
}
