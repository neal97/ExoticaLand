<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CgmController extends MyController
{
    #[Route('/cgm/cgu', name: 'app_cgu')]
    public function index(): Response
    {
        return $this->render('cgm/cgu.html.twig', [
            'controller_name' => 'CgmController',
        ]);
    }


    #[Route('/cgm/cgv', name: 'app_cgv')]
    public function cgv(): Response
    {
        return $this->render('cgm/cgv.html.twig', [
            'controller_name' => 'CgmController',
        ]);
    }

    #[Route('/cgm/mentions', name: 'app_mention')]
    public function mention(): Response
    {
        return $this->render('cgm/mention.html.twig', [
            'controller_name' => 'CgmController',
        ]);
    }
}
