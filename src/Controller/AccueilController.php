<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use App\Repository\CategorieRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends MyController
{
    #[Route('/', name: 'app_accueil')]
    public function index(ArticlesRepository $repoArticles,PaginatorInterface $paginator, Request $request, CategorieRepository $repoCategorie): Response
    {
        $articles = $repoArticles->findAll();
        $pagination = $paginator->paginate(
            $repoArticles->paginationQuery(),
            $request->query->get('page', 1),
            6
        );

        $categorie = $repoCategorie->findAll();
        // $this->getUser()
        




        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'articles' => $articles,
            'pagination' =>$pagination,
            // 'categorie' => $categorie
        ]);
    }
    
    
    
}
