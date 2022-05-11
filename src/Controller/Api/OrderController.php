<?php

namespace App\Controller\Api;

use DateTime;
use App\Entity\Order;
use App\Entity\Article;
use App\Form\OrderType;
use App\Entity\Orderlist;
use App\Form\ArticleType;
use App\Form\OrderAddType;
use App\Repository\OrderlistRepository;
use OpenApi\Annotations as OA;
use App\Repository\UserRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class OrderController extends AbstractController
{
    /**
     * @Route("/api/orders", name="app_api_browse_order", methods={"GET"})
     *  
     */
    public function browse(OrderRepository $orderRepository): JsonResponse
    {
        $orders = $orderRepository->findAll();

        return $this->json(
            $orders,

            Response::HTTP_OK,
            [],
            [
                "groups" => [
                    "browse_order"
                ]
            ]
        );
    }

    /**
     * @Route("/api/order/{id}", name="app_api_read_order", methods={"GET"}, requirements={"id":"\d+"})
     *  
     */
    public function read(Order $order = null): JsonResponse
    {
        if ($order === null) {
            return $this->json(
                $order,
                Response::HTTP_NOT_FOUND
            );
        }
        return $this->json(
            $order,
            Response::HTTP_OK,
            [],
            [
                "groups" => [
                    "read_order"
                ]
            ]
        );
    }

    /**
     * @Route("/api/orders/{id}/status", name="app_api_read_order_status", methods={"GET"}, requirements={"id":"\d+"})
     *  
     */
    public function readByStatus(int $id, OrderRepository $orderRepository): JsonResponse
    {
        $orders = $orderRepository->findAllByStatus($id);

        return $this->json(
            $orders,

            Response::HTTP_OK,
            [],
            [
                "groups" => [
                    "browse_order"
                ]
            ]
        );
    }

    /**
     * Crée une nouvelle commande
     * 
     * @Route("/api/order/add", name="add_order", methods={"POST"})
     *
     * @param EntityManagerInterface $entityManagerInterface
     * @param Request $request
     * @param SerializerInterface $serializerInterface
     * @return JsonResponse
     * 
     *  @OA\RequestBody(
     *     @Model(type=OrderAddType::class)
     * )
     */
    public function add(EntityManagerInterface $entityManagerInterface, Request $request, SerializerInterface $serializerInterface, ValidatorInterface $validator): JsonResponse
    {
        // On récupére le contenu Json de la requête
        $jsoncontent = $request->getContent();
        // {
        //   "status": 0,
        //   "user": 7,
        //   "deliveries": 11,
        //   "article": [
        //     223,224
        //   ]
        // }

        //le deserialize va appeler tout les deserializer dont celui que j'ai créer pour denormalizer et donc créer mes entity "étrangères"
        $order = $serializerInterface->deserialize($jsoncontent, Order::class, 'json');
        $errorsList = $validator->validate($order);

        if (count($errorsList) > 0) {
            return $this->json(
                $errorsList,
                Response::HTTP_BAD_REQUEST,
                [],
                []
            );
        };
        $order->setCreatedAt(new DateTime());

        foreach ($order->getOrderlists() as $orderList) {
            $orderList->setCreatedAt(new DateTime());
            $entityManagerInterface->persist($orderList);
        }
    
        $entityManagerInterface->persist($order);
        $entityManagerInterface->flush();

        return $this->json(
            $order,
            Response::HTTP_CREATED,
            [],
            ["groups" => [
                "read_order"
            ]]
        );
    }
    /**
     * @Route("/api/order/{id}", name="app_back_delete_order", methods={"DELETE"})
     * 
     * @param EntityManagerInterface $entityManagerInterface
     * @return JsonResponse
     * 
     *  
     */
    // public function delete(int $id, Order $order, EntityManagerInterface $entityManager, OrderRepository $orderRepository, OrderlistRepository $orderlistRepository): JsonResponse
    // {
        
    //     $order = $orderRepository->find($id);
    //     $orderList = $orderlistRepository->findBy($id, "order_id");
    //     // Si l'utilisateur n'existe pas
    //     if ($order == null) {
    //         return $this->json("Aucune commande ne correspond à cet id !",Response::HTTP_NOT_FOUND);
    //     }
        
    //         $entityManager->remove($order);
    //         $entityManager->remove($orderList);
    //         $entityManager->flush();

    //     return $this->json(
    //         "la commande a bien été supprimer",
    //         Response::HTTP_OK);
    // }
}
