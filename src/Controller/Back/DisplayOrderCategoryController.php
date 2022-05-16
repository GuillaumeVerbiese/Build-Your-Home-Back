<?php

namespace App\Controller\Back;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DisplayOrderCategoryController extends AbstractController
{
    /**
     * @Route("/back/display/order/category", name="app_back_display_order_category", methods={"GET", "POST"})
     */
    public function index(Request $request, CategoryRepository $categoryRepository, EntityManagerInterface $entityManagerInterface)
    {
        $originCategories = $categoryRepository->findAll();
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
                return $this->render('back/display_order_category/index.html.twig', [
                    'categories' => $originCategories,
                ])
                ;}
            
            
            // REMISE A 0 DES DISPLAYORDER
            $categories = $categoryRepository->findAll();

            foreach ($categories as $category) {
                $category->setDisplayOrder(0);
                $entityManagerInterface->persist($category);
            }
            $entityManagerInterface->flush();

            // Changement des displayOrder en fonction du form

            foreach ($orderList as $key=>$value) {
                $categoryToModify =  $categoryRepository->findOneBy(array('name'=>$value));
                $categoryToModify->setDisplayOrder($key);
                $entityManagerInterface->persist($categoryToModify);
            }
        
            $entityManagerInterface->flush();
        }
        $originDisplayOrder = [];
        foreach($originCategories as $keys => $value){
            $displayOrder = $value->getDisplayOrder() ;
            if($displayOrder != 0){
            $originDisplayOrder [$displayOrder] = $value ;
            dump($originDisplayOrder);
            }
            ;
        }
        

        return $this->render('back/display_order_category/index.html.twig', [
            'categories' => $originCategories,
            'categoryOrderbyDisplay' => $originDisplayOrder
        ]);
    }
}
