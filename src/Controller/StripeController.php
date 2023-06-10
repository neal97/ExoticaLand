<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Commande;
use App\Repository\ArticlesRepository;
use App\Repository\CommandeRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Stripe;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class StripeController extends MyController
{
    #[Route('/paiement', name: 'paiement')]
    public function index(SessionInterface $session, ArticlesRepository $articlesRepository, EntityManagerInterface $em): Response
    {


        // Vous récupérez le panier
        // Ne pas oublier de créer une commande (en BDD)
        // Lui mettre un token fort et unique et aléatoire
        $panier = $session->get('cart', []);
        
        if (empty($panier)) 
            return $this->redirectToRoute('get_cart');
        
        $commande = new Commande;
        $commande->setToken(hash("sha256", random_bytes(32)));
        $commande->setDate(new DateTime());

        $tab = [
            'mode' => 'payment',
            'success_url' => $this->generateUrl('app_success', [
                'token' => $commande->getToken() // Le token de la commande (mis à la main pour ma part parce que j'ai pas de commande)
            ], UrlGeneratorInterface::ABSOLUTE_URL), // Attention, URL absolue
            'cancel_url' => $this->generateUrl('app_failure', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'line_items' => []
        ];

        foreach ($panier as $id => $quantite) {

            $article = $articlesRepository->find($id);

            $commande->addArticle($article);

            $tab['line_items'][] =  [
                'price_data' => [
                    'currency' => 'EUR',
                    'product_data' => [
                        'name' => $article->getTitre(),
                        'images' => [$article->getPhoto()] // Attention, URL absolue
                    ],
                    'unit_amount' => $article->getPrix() * 100 // Attention, prix en centimes
                ],
                'quantity' => $quantite,
            ];
        }

        \Stripe\Stripe::setApiKey($this->getParameter('stripeSecretKey'));
       
        $checkout_session = \Stripe\Checkout\Session::create($tab);

        $em->persist($commande);
        $em->flush();

        return $this->redirect($checkout_session->url);
    }


    #[Route('/command_success/{token}', 'app_success')]
    public function success($token, CommandeRepository $commandeRepository)
    {
       $commande = $commandeRepository->findOneBy(['token'=>$token]);
       $commande->getArticles();
        // NE pas oublier de valider la commande
        // Et de sortir les stocks
        return new Response('Success');
    }

    #[Route('/command_failure', 'app_failure')]
    public function failure()
    {
        // Ne pas oublier d'informer le visiteur
        // S'il doit y avoir de la logique, la faire
        return new Response('Failure');
    }
}












// $panier = $session->get('cart', []);

//         if (empty($panier)) {
//             $this->addFlash('error', 'votre panier est vide !');
//             return $this->redirectToRoute('get_cart');
//         }

//              Stripe::setApiKey($this->getParameter('stripeSecretKey'));
             
//             $infos = [
//             'mode' => 'paiement',
//             'success_url' => $this->generateUrl('commande_success', [], UrlGeneratorInterface::ABSOLUTE_URL),
//             'echec_url' => $this->generateUrl('commande_echec', [], UrlGeneratorInterface::ABSOLUTE_URL),
//         ];



//         $articles = $articlesRepository->getAllArticles(array_keys($panier));

//         foreach ($panier as $id => $quantite) {
            
//             $infos['line_items'][] = [
           
//                 'price_data' => [
//                    'currency' => 'eur',
//                    'product_data' => [
//                       'name' => $articles->getTitre(),
//                       'images' => [$articles->getPhoto()]
    
//                    ],
    
//                    'unit_amount' => $articles->getPrix() * 100
//                 ],
    
//                 'quantity' => $quantite,
    
    
    
//             ];

//         }


//         dd($infos);