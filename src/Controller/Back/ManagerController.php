<?php

namespace App\Controller\Back;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Entity\Order;
use App\Repository\ArticleRepository;
use App\Repository\OrderlistRepository;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/back")
 */
class ManagerController extends AbstractController
{

    /**
     * @Route("/management/{status}", name="app_back_order_management", methods={"GET"}, requirements={"status":"[0-4]"})
     */
    public function orderManagement(int $status, OrderRepository $orderRepository): Response
    {
        // On récupère les commandes par rapport au status récupéré dans l'url
        $orders = $orderRepository->findBy(["status"=>$status],["createdAt" => "ASC"]);
        // on crée une liste avec les status compréhensible par l'utilisateur (indexé dans le bon ordre)
        $statusList = ["en attentes","validées","en attentes de stock","expédiées","archivées"];
        // On renvoie le bon template avec les bonnes données
        return $this->render('back/order_management/index.html.twig', [
            'orders' => $orders,
            'status' => $statusList[$status]
        ]);
    }

    /**
     * @Route("/management/show/{id}", name="app_back_order_management_show", methods={"GET", "POST"}, requirements={"id":"\d+"})
     */
    public function showOrderManagemen(Request $request, Order $order, EntityManagerInterface $entityManager, OrderlistRepository $orderlistRepository): Response
    {
        
        $statusList = ["en attente","validée","en attente de stock","expédiée","archivée"];
        
        

        if ($request->getMethod() == "POST") {

            // dd($request);
            $order->setStatus($request->get("status"));
            $order->setUpdatedAt(new DateTime());
            // TODO récupérer les données en $_POST 
            if ($request->get("articlesList")) {
                $articlesList = $request->get("articlesList");
                // TODO foreach find(article)->setStock( - quantity )->setUpdatedAt(now)
                foreach ($articlesList as $articleId => $quantityToSub) {
                    $article = $entityManager->find(Article::class, $articleId);
                    $article->setStock($article->getStock()-$quantityToSub);
                    // TODO passer validate des orderlists a true
                    if ($quantityToSub > 0) {
                        $orderlist = $orderlistRepository->findOneBy(["order"=>$order,"article"=>$article]);
                        $orderlist->setValidate(true);
                    }
                }
            }

            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Votre commande a bien été modifier.'
            );

            return $this->redirectToRoute('app_back_order_management', ["status"=>$order->getStatus()], Response::HTTP_SEE_OTHER);
        }
        return $this->render('back/order_management/show.html.twig', [
            'order' => $order,
            'status' => $statusList
        ]);
    }
    // TODO faire une méthode "itemsToOrder" orderlist->findAll ->foreach comparer article stock et quantity ->renvoyer un tableau d'article avec la quantité manquante

    /**
     * @Route("/management/items-to-order", name="app_back_management_itemsToOrder", methods={"GET"})
     *
     * @param ArticleRepository $articleRepository
     * @return Response
     */
    public function showEmptyStock(ArticleRepository $articleRepository): Response
    {
        $articlesList = $articleRepository->findEmptyStock();

        return $this->render('back/order_management/list.html.twig', ['articlesList' => $articlesList]);
    }
}
