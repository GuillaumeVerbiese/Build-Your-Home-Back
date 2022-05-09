<?php

namespace App\Controller\Back;

use DateTime;
use App\Entity\VAT;
use App\Form\VATType;
use App\Repository\VATRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/back/vat")
 */
class VATController extends AbstractController
{
    /**
     * @Route("/", name="app_back_vat_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $vATs = $entityManager
            ->getRepository(VAT::class)
            ->findAll();

        return $this->render('back/vat/index.html.twig', [
            'vats' => $vATs,
        ]);
    }

    /**
     * @Route("/new", name="app_back_vat_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $vAT = new VAT();
        $vAT->setCreatedAt(new DateTime());
        $form = $this->createForm(VATType::class, $vAT);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($vAT);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Votre taux de tva a bien été ajouter.'
            );

            return $this->redirectToRoute('app_back_vat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/vat/new.html.twig', [
            'vat' => $vAT,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_vat_show", methods={"GET"})
     */
    public function show(VAT $vAT): Response
    {
        return $this->render('back/vat/show.html.twig', [
            'vat' => $vAT,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_back_vat_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, VAT $vAT, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VATType::class, $vAT);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vAT->setUpdatedAt(new DateTime()) ;
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Votre taux de tva a bien été modifier.'
            );

            return $this->redirectToRoute('app_back_vat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/vat/edit.html.twig', [
            'vat' => $vAT,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_vat_delete", methods={"POST"})
     */
    public function delete(Request $request, VAT $vAT, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vAT->getId(), $request->request->get('_token'))) {
            $entityManager->remove($vAT);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Votre taux de tva a bien été supprimer.'
            );
        }

        return $this->redirectToRoute('app_back_vat_index', [], Response::HTTP_SEE_OTHER);
    }
}
