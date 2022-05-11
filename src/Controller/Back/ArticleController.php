<?php

namespace App\Controller\Back;

use DateTime;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\AsciiSlugger;


/**
 * @Route("/back/article")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="app_back_article_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $articles = $entityManager
            ->getRepository(Article::class)
            ->findAll();

        return $this->render('back/article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/new", name="app_back_article_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $article->setCreatedAt(new DateTime()) ;
        $article->setDisplayOrder(0);
        
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $slugger = new AsciiSlugger();
            $slug = $slugger->slug($article->getName());
            $article->setSlug($slug);


            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Votre article a bien été enregistrer.'
            );

            return $this->redirectToRoute('app_back_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_article_show", methods={"GET"})
     */
    public function show(Article $article): Response
    {
        return $this->render('back/article/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_back_article_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setUpdatedAt(new DateTime()) ;

            
            $slugger = new AsciiSlugger();
            $slug = $slugger->slug($article->getName());
            $article->setSlug($slug);
            
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Votre article a bien été modifier.'
            );

            return $this->redirectToRoute('app_back_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_back_article_delete", methods={"POST"})
     */
    public function delete(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager->remove($article);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Votre article a bien été supprimer.'
            );
        }

        return $this->redirectToRoute('app_back_article_index', [], Response::HTTP_SEE_OTHER);
    }
}
