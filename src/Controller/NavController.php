<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NavController extends MyController
{
    #[Route('/nav', name: 'app_nav')]
    public function index(CategorieRepository $repoCategorie, ): Response
    {
        $categorie = $repoCategorie->findAll();


            dd($categorie);
            exit();


        return $this->render('nav/nav.html.twig', [
            'controller_name' => 'NavController',
            
        ]);
    }

 

}
