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
     * @Route("/user/{id}", name="_delete_user", requirements={"id":"\d+"}, methods={"DELETE"})
     *
     * @param EntityManagerInterface $entityManagerInterface
     * @param Request $request
     * @param SerializerInterface $serializerInterface
     * @return JsonResponse
     */
    public function delete(int $id, EntityManagerInterface $entityManagerInterface, UserRepository $userRepository): JsonResponse
    {
        // On récupére l'utilisateur
        $user = $userRepository->find($id);
        // On le supprime avec l'entityManager
        $entityManagerInterface->remove($user);
        // On le supprime de la DB
        $entityManagerInterface->flush();

        return $this->json($user,Response::HTTP_OK);
        
    }

}
