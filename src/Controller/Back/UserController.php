<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserEditType;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/back/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="app_back_user_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $users = $entityManager
            ->getRepository(User::class)
            ->findAll();

        return $this->render('back/user/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/new", name="app_back_user_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $user->setCreatedAt(new DateTime());
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            try {
                $entityManager->flush();
            }catch(UniqueConstraintViolationException $e){
                $this->addFlash('danger','Cette adresse email est déjà lié à un autre compte !');
                return $this->redirectToRoute('app_back_user_new', [], Response::HTTP_FOUND); // TODO change code réponse
            }

            return $this->redirectToRoute('app_back_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_user_show", methods={"GET"}, requirements={"id":"\d+"})
     */
    public function show(User $user = null): Response
    {
        if ($user === null) {
            $this->addFlash('danger',"Cet utilisateur n'existe pas !");
            return $this->redirectToRoute('app_back_user_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('back/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_back_user_edit", methods={"GET", "POST"}, requirements={"id":"\d+"})
     */
    public function edit(Request $request, User $user = null, EntityManagerInterface $entityManager): Response
    {
        if ($user === null) {
            $this->addFlash('danger',"Cet utilisateur n'existe pas !");
            return $this->redirectToRoute('app_back_user_index', [], Response::HTTP_SEE_OTHER);
        }
        $form = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setUpdatedAt(new DateTime());
            try {
                $entityManager->flush();
            }catch(UniqueConstraintViolationException $e){
                $this->addFlash('danger','Cette adresse email est déjà lié à un autre compte !');
                return $this->redirectToRoute('app_back_user_edit', ["id"=>$user->getId()], Response::HTTP_FOUND);
            }

            return $this->redirectToRoute('app_back_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_user_delete", methods={"POST"}, requirements={"id":"\d+"})
     */
    public function delete(Request $request, User $user = null, EntityManagerInterface $entityManager): Response
    {
        if ($user === null) {
            $this->addFlash('danger',"Cet utilisateur n'existe pas !");
            return $this->redirectToRoute('app_back_user_index', [], Response::HTTP_SEE_OTHER);
        }
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            // On récupére ses favoris
        $userFavorites = $user->getFavorites();
        // Si il y a des favories
        if ($userFavorites !== null) {
            // On boucle sur le tableau pour les supprimer
            foreach ($userFavorites as $favorite) {
                $entityManager->remove($favorite);
            }
        }
        // On récupére ses commandes
        $userOrders = $user->getOrders();
        // Si il y a des commandes
        if ($userOrders !== null) {
        
            // On boucle sur le tableau pour les supprimer
            foreach ($userOrders as $order) {
                // Avant de supprimer la commande il faut supprimer leurs orderlist
                $orderOrderlists = $order->getOrderlists();
                // On boucle sur le tableau pour les supprimer
                foreach ($orderOrderlists as $orderlist) {
                    $entityManager->remove($orderlist);
                }
                // Puis on supprime la commande
                $entityManager->remove($order);
            }
        }
        // On récupére ses commentaires
        $userComments = $user->getComments();
        // Si il y a des commandes
        if ($userComments !== null) {
        
            // On boucle sur le tableau pour supprimer leur utilisateur associé
            foreach ($userComments as $comment) {
                $comment->setUser(null);
            }
        }
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_back_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
