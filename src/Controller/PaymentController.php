<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PaymentController extends AbstractController {
    #[Route('/payment', name: 'app_payment')]
    public function index(): Response {
        // Vous récupérez le panier
        // Ne pas oublier de créer une commande (en BDD)
        // Lui mettre un token fort et unique et aléatoire

        \Stripe\Stripe::setApiKey($this->getParameter('stripe.secret'));

        $checkout_session = \Stripe\Checkout\Session::create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'EUR',
                        'product_data' => [
                            'name' => 'Produit n°1',
                            'images' => ['https://picsum.photos/800']
                        ],
                        'unit_amount' => 3550 
                    ],
                    'quantity' => 1,
                ],
                [
                    'price_data' => [
                        'currency' => 'EUR',
                        'product_data' => [
                            'name' => 'Produit n°2',
                            'images' => ['https://picsum.photos/801']
                        ],
                        'unit_amount' => 1799
                    ],
                    'quantity' => 3,
                ],
                [
                    'price_data' => [
                        'currency' => 'EUR',
                        'product_data' => [
                            'name' => 'Produit n°3',
                            'images' => ['https://picsum.photos/701']
                        ],
                        'unit_amount' => 15999
                    ],
                    'quantity' => 15,
                ],
                // Une ligne dans le tableau pour chaque ligne du panier

                // [
                //     'price_data' => [
                //         'currency' => 'EUR',
                //         'product_data' => [
                //             'name' => $produit->getNom(),
                //             'images' => [$produit->getImage()] // Attention, URL absolue
                //         ],
                //         'unit_amount' => $produit->getPrix() * 100 // Attention, prix en centimes
                //     ],
                //     'quantity' => $quantite,
                // ],
            ],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('app_success', [
                'token' => hash('sha256', random_bytes(32)) // Le token de la commande (mis à la main pour ma part parce que j'ai pas de commande)
            ], UrlGeneratorInterface::ABSOLUTE_URL), // Attention, URL absolue
            'cancel_url' => $this->generateUrl('app_failure', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        return $this->redirect($checkout_session->url);
    }

    #[Route('/command_success/{token}', 'app_success')]
    public function success() {
        // NE pas oublier de valider la commande
        // Et de sortir les stocks
        return new Response('Success');
    }

    #[Route('/command_failure', 'app_failure')]
    public function failure() {
        // Ne pas oublier d'informer le visiteur
        // S'il doit y avoir de la logique, la faire
        return new Response('Failure');
    }
}
