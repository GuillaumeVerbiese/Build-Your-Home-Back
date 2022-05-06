<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api", name="app_api")
 */
class UserController extends AbstractController
{
    /**
     * Renvoie l'utilisateur correspondant à l'id
     * 
     * @Route("/user/{id}", name="_read_user", requirements={"id":"\d+"}, methods={"GET"})
     * 
     * @OA\Response(
     *     response=200,
     *     description="Returns one user",
     *     @OA\JsonContent(ref=@Model(type=User::class, groups={"readUser"}))
     * )
     * 
     * @OA\Response(
     *     response=404,
     *     description="User not found"
     * )
     *
     * @param integer $id
     * @param UserRepository $userRepository
     * @return JsonResponse
     */
    public function read(int $id,UserRepository $userRepository): JsonResponse
    {
        // On récupére l'utilisateur
        $user = $userRepository->find($id);
        // Si aucun utilisateur ne correspondant à cet id
        if ($user === null) {
            // On renvoie un code reponse 404
            return $this->json("Aucun utilisateur ne correspond à cet id !",Response::HTTP_NOT_FOUND);
        }
        // Sinon on renvoie l'utilisateur avec un code reponse 200
        return $this->json($user,Response::HTTP_OK,[],["groups"=>"readUser"]);
    }

    /**
     * Crée un nouvel utilisateur (à finir)
     * 
     * @Route("/user/add", name="_add_user", methods={"POST"})
     *
     * @param EntityManagerInterface $entityManagerInterface
     * @param Request $request
     * @param SerializerInterface $serializerInterface
     * @return JsonResponse
     */
    public function add(EntityManagerInterface $entityManagerInterface, Request $request, SerializerInterface $serializerInterface): JsonResponse
    {
        // On récupére le contenu Json de la requête
        $jsoncontent = $request->getContent();
        // TODO à finir après avoir fait le crud pour les validations
        
    }
    

    /**
     * Modifie l'utilisateur correspondant à l'id (à finir)
     * 
     * @Route("/user/{id}", name="_modify_user", requirements={"id":"\d+"}, methods={"PATCH"})
     *
     * @param EntityManagerInterface $entityManagerInterface
     * @param Request $request
     * @param SerializerInterface $serializerInterface
     * @return JsonResponse
     */
    public function modify(EntityManagerInterface $entityManagerInterface, Request $request, SerializerInterface $serializerInterface): JsonResponse
    {
        // On récupére le contenu Json de la requête
        $jsoncontent = $request->getContent();
        // TODO à finir après avoir fait le crud pour les validations
        
    }

    /**
     * Supprime l'utilisateur correspondant à l'id
     * 
     * @OA\Response(
     *     response=200,
     *     description="User is delete"
     * )
     * 
     * @OA\Response(
     *     response=404,
     *     description="User not found"
     * )
     * 
     * @Route("/user/{id}", name="_delete_user", requirements={"id":"\d+"}, methods={"DELETE"})
     *
     * @param integer $id
     * @param EntityManagerInterface $entityManagerInterface
     * @param UserRepository $userRepository
     * @return JsonResponse
     */
    public function delete(int $id, EntityManagerInterface $entityManagerInterface, UserRepository $userRepository): JsonResponse
    {
        // On récupére l'utilisateur
        $user = $userRepository->find($id);
        // Si l'utilisateur n'existe pas
        if ($user == null) {
            return $this->json("Aucun utilisateur ne correspond à cet id !",Response::HTTP_NOT_FOUND);
        }
        // On récupére ses favoris
        $userFavorites = $user->getFavorites();
        // Si il y a des favories
        if ($userFavorites !== null) {
            // On boucle sur le tableau pour les supprimer
            foreach ($userFavorites as $favorite) {
                $entityManagerInterface->remove($favorite);
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
                    $entityManagerInterface->remove($orderlist);
                }
                // Puis on supprime la commande
                $entityManagerInterface->remove($order);
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
            // On supprime l'utilisateur
        $entityManagerInterface->remove($user);
        // On le supprime de la DB
        $entityManagerInterface->flush();

        return $this->json("Utilisateur supprimé",Response::HTTP_OK);
        
    }

}
