<?php

namespace App\Controller\Api;

use App\Entity\Favorite;
use App\Entity\Article;
use App\Entity\User;
use App\Form\FavoriteType;
use App\Repository\FavoriteRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(name="favorite")
 */
class FavoriteController extends AbstractController
{
    /**
     * Crée un nouveau favori
     * 
     * @Route("/api/favorite/add", name="app_api_add_favorite", methods={"POST"})
     *  
     *
     * @param EntityManagerInterface $entityManagerInterface
     * @param Request $request
     * @param SerializerInterface $serializerInterface
     * @return JsonResponse
     * 
     * 
     * 
     *  @OA\RequestBody(
     *     @Model(type=FavoriteType::class)
     * )
     */
    public function add(EntityManagerInterface $entityManagerInterface, Request $request, SerializerInterface $serializerInterface, ValidatorInterface $validator): JsonResponse
    {
        // On récupére le contenu Json de la requête
        $jsoncontent = $request->getContent();

        //le deserialize va appeler tout les deserializer dont celui que j'ai créer pour denormalizer et donc créer mes entity "étrangères"
        $favorite = $serializerInterface->deserialize($jsoncontent, Favorite::class, 'json');
        $errorsList = $validator->validate($favorite);

        if (count($errorsList) > 0) {
            return $this->json(
                $errorsList,
                Response::HTTP_BAD_REQUEST,
                [],
                []
            );
        };
        
        $entityManagerInterface->persist($favorite);
        $entityManagerInterface->flush();

        return $this->json(
            $favorite,
            Response::HTTP_CREATED,
            [],
            [
                "groups" => [
                    "read_article"
                ]
            ]
        );
    }
    /**
     * Supprime le favori correspondant à l'id
     * 
     * @Route("/api/favorite/{id}", name="app_back_delete_favorite", methods={"DELETE"})
     * 
     * @param EntityManagerInterface $entityManagerInterface
     * @return JsonResponse
     * 
     *  
     */
    public function delete(int $id, Favorite $favorite, EntityManagerInterface $entityManager, FavoriteRepository $favoriteRepository): JsonResponse
    {
        
        $favorite = $favoriteRepository->find($id);
        // Si l'utilisateur n'existe pas
        if ($favorite == null) {
            return $this->json("Aucun favori ne correspond à cet id !",Response::HTTP_NOT_FOUND);
        }
        
            $entityManager->remove($favorite);
            $entityManager->flush();

        return $this->json(
            "le favori a bien été supprimer",
            Response::HTTP_OK);
    }
}
