<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Form\ArticlesType;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends MyController
{
    #[Route('admin/articles', name: 'app_articles')]
    public function index(Request $request, ArticlesRepository $repoArticles, EntityManagerInterface $manager): Response
    {
        $articles = $repoArticles->findAll();
        $articlesEntity = new Articles;
        $form = $this->createForm(ArticlesType::class, $articlesEntity);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $articlesEntity->setDate(new \DateTime()); 
            $manager->persist($articlesEntity);
            $manager->flush(); 
            $this->addFlash('succes',' Le Membre a bien été Enregistrer');
            return $this->redirectToRoute("app_articles");
        }

        return $this->render('articles/index.html.twig', [
            'controller_name' => 'ArticlesController',
            'articles' => $articles ,
            'formArticles' => $form->createView()
        ]);
    }

    #[Route('/articles/update/{id}', name: 'update_articles')]
    public function update_articles($id, ArticlesRepository $reposArticles, Request $request, EntityManagerInterface $manager)
    {
        $articles = $reposArticles->find($id);
        $form = $this->createForm(ArticlesType::class, $articles);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($articles);
            $manager->flush();

            $this->addFlash("success", "membre N°" . $articles->getId() . " a bien été modifié");
            return $this->redirectToRoute("app_articles");
        }
        return $this->render("articles/update.html.twig",[
            "formUpdate" => $form->createView(),
            "articles" => $articles
        ]);
    }


    #[Route('/articles/details/{id}', name: 'details_articles')]
    public function details_articles($id, ArticlesRepository $reposArticles)
    {
        $articles = $reposArticles->find($id);
        
        
        return $this->render("articles/details.html.twig",[
            "articles" => $articles
        ]);
    }



    #[Route('/articles/delete/{id}', name: 'delete_articles')]
    public function delete(Articles $articles, EntityManagerInterface $manager)
    {
      

       $id = $articles->getId();

       $manager->remove($articles);
       $manager->flush();

       $this->addFlash("Succes","l'articles N°". $id . "a bien été supprimer");
       return $this->redirectToRoute("app_articles");
     

}



}
