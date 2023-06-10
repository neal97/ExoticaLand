<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends MyController
{
    #[Route('/cart', name: 'get_cart')]
    public function index(CartService $cartService): Response
    {
        // dd($cartService->getTotal()); // permet de voir ce qu'il y a dans le panier 

        return $this->render('cart/index.html.twig', [
            'cart' => $cartService->getTotal(),
        ]);
    }


// Ajout d'un produit au panier via le boutton "ajouter au panier" ou + dans panier.
    #[Route('/add/cart/{id}', name: 'post_cart')]
    public function add(CartService $cartService, Articles $articles): RedirectResponse
    {

        $cartService->addCart($articles->getId());
        return $this->redirectToRoute('get_cart');
    }

    

// Suppression d'un seul produit du panier 
    #[Route('/delete/cart/{id}', name: 'delete_cart')]
    public function delete($id, CartService $cartService): RedirectResponse
    {

        $cartService->deleteCart($id);
        return $this->redirectToRoute('get_cart');
    }


// Suppression de tous les produits du panier 
    #[Route('/delete/all/cart', name: 'delete_all_cart')]
    public function deleteCartById(CartService $cartService): RedirectResponse
    {

        $cartService->deleteAllCart();
        return $this->redirectToRoute('app_accueil');
    }

// Décrémentation de la quantité d'un produit dans le panier via le boutton - (moins)
    #[Route('/decrease/cart/{id}', name: 'decrease_cart')]
    public function decrease($id, CartService $cartService): RedirectResponse
    {

        $cartService->decrease($id);
        return $this->redirectToRoute('get_cart');
    }

}








