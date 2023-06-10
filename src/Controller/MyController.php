<?php

namespace App\Controller;


use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class MyController extends AbstractController {
    protected CategorieRepository $categorieRepository;

    public function __construct(CategorieRepository $categorieRepository) {
        $this->categorieRepository = $categorieRepository;
    }

    protected function render(string $view, array $parameters = [], Response $response = null): Response {
        $parameters['categorie'] = $this->categorieRepository->findAll();
        return parent::render($view, $parameters, $response);
    }
}
