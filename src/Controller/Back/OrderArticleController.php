<?php

namespace App\Controller\Back;

use App\Entity\Article;
use App\Form\ArticleOrderType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderArticleController extends AbstractController
{
    /**
     * @Route("/back/order/article/test", name="app_back_order_article", methods={"GET", "POST"})
     * 
     * 
     */
    public function index(Request $request, ArticleRepository $articleRepository, EntityManagerInterface $entityManagerInterface)
    {
        $originArticles = $articleRepository->findAll();

        if ($request->getMethod()==="POST") {
            $orderList = [];
            $orderList [1]= $request->get('1');
            $orderList [2] = $request->get('2');
            $orderList [3] = $request->get('3');
            $orderList [4] = $request->get('4');
            $orderList [5] = $request->get('5');
            $orderList [6] = $request->get('6');
            $orderList [7] = $request->get('7');
            $orderList [8] = $request->get('8');
            $orderList [9] = $request->get('9');
            $orderList [10] = $request->get('10');
            
            $uniq = array_unique($orderList);
            $orderListUnique = count($uniq) != count($orderList);
            
            if($orderListUnique===true){
                $this->addFlash(
                    'doublon',
                    'Il y a un doublon dans les articles à afficher'
                );
                return $this->render('back/order_article/index.html.twig', [
                    'articles' => $originArticles,
                ])
                ;}
            
            
            // REMISE A 0 DES DISPLAYORDER
            $articles = $articleRepository->findAll();

            foreach ($articles as $article) {
                $article->setDisplayOrder(0);
                $entityManagerInterface->persist($article);
            }
            $entityManagerInterface->flush();

            // Changement des displayOrder en fonction du form

            foreach ($orderList as $key=>$value) {
                $articleToModify =  $articleRepository->findOneBy(array('name'=>$value));
                $articleToModify->setDisplayOrder($key);
                $entityManagerInterface->persist($articleToModify);
            }
        
            $entityManagerInterface->flush();
        }
        return $this->render('back/order_article/index.html.twig', [
            'articles' => $originArticles,
        ]);
    }
    
}
