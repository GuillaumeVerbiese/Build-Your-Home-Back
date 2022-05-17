<?php

namespace App\Controller\Back;

use App\Entity\Article;
use App\Entity\Order;
use App\Entity\Orderlist;
use App\Form\OrderManagementType;
use App\Form\OrderType;
use App\Repository\OrderlistRepository;
use App\Repository\OrderRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/back/order")
 */
class OrderController extends AbstractController
{
    /**
     * @Route("/", name="app_back_order_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $orders = $entityManager
            ->getRepository(Order::class)
            ->findAll();

        return $this->render('back/order/index.html.twig', [
            'orders' => $orders,
        ]);
    }

    

    /**
     * @Route("/{id}", name="app_back_order_show", methods={"GET"})
     */
    public function show(Order $order): Response
    {
        return $this->render('back/order/show.html.twig', [
            'order' => $order,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_back_order_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Order $order, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Votre commande a bien été modifier.'
            );

            return $this->redirectToRoute('app_back_order_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/order/edit.html.twig', [
            'order' => $order,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_order_delete", methods={"POST"})
     */
    public function delete(Request $request, Order $order, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
            $entityManager->remove($order);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Votre commande a bien été supprimer.'
            );
        }

        return $this->redirectToRoute('app_back_order_index', [], Response::HTTP_SEE_OTHER);
    }

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
    // TODO faire un ManagementControler et y ranger les 2 méthodes ci-dessus
    // TODO faire une méthode "itemsToOrder" orderlist->findAll ->foreach comparer article stock et quantity ->renvoyer un tableau d'article avec la quantité manquante
}
