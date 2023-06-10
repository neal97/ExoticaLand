<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends MyController
{
    #[Route('/commande-success', name: 'commande_success')]
    public function success(): Response
    {



        return $this->render('stripe/success.html.twig', [
            'controller_name' => 'CommandeController',
        ]);
    }





    #[Route('/commande-echec', name: 'commande_echec')]
    public function echec(): Response
    {


        
        return $this->render('stripe/echec.html.twig', [
            'controller_name' => 'CommandeController',
        ]);
    }
}
