<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Proxies\__CG__\App\Entity\Categorie as EntityCategorie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends MyController
{
    #[Route('admin/categorie', name: 'app_categorie')]
    public function index(Request $request, CategorieRepository $repoCategorie, EntityManagerInterface $manager): Response
    {
        $categorie = $repoCategorie->findAll();
        $categorieEntity = new Categorie;
        $form = $this->createForm(CategorieType::class, $categorieEntity);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($categorieEntity);
            $manager->flush(); 
            $this->addFlash('succes',' La catégorie a bien été Enregistrer');
            return $this->redirectToRoute("app_categorie");
        }

        return $this->render('categorie/index.html.twig',  [
            'controller_name' => 'CategorieController',
            'categorie' => $categorie ,
            'formCategorie' => $form->createView()
        ]);
    }



    #[Route('/categorie/update/{id}', name: 'update_categorie')]
    public function update_categorie($id, CategorieRepository $reposCategorie, Request $request, EntityManagerInterface $manager)
    {
        $categorie = $reposCategorie->find($id);
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($categorie);
            $manager->flush();

            $this->addFlash("success", "categorie N°" . $categorie->getId() . " a bien été modifié");
            return $this->redirectToRoute("app_categorie");
        }
        return $this->render("categorie/update.html.twig",[
            "formCategorie" => $form->createView(),
            "categorie" => $categorie
        ]);
    }


    #[Route('/categorie/{id}', name: 'categorie_articles')]
    public function details_articles($id, CategorieRepository $reposCategorie, EntityManagerInterface $manager)
    {
        $filtre = $reposCategorie->find($id);
        
        $produits = $filtre->getArticles();

        // dd($produits);
        return $this->render("categorie/filtre.html.twig",[
            "produits" => $produits
        ]);
    }




    #[Route('/categorie/delete/{id}', name: 'delete_categorie')]
    public function delete(Categorie $categorie, EntityManagerInterface $manager)
    {
      

       $id = $categorie->getId();

       $manager->remove($categorie);
       $manager->flush();

       $this->addFlash("Succes","la categorie N°". $id . "a bien été supprimer");
       return $this->redirectToRoute("app_categorie");
     

}



}
