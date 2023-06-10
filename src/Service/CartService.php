<?php

namespace App\Service;

use App\Entity\Articles;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    private RequestStack $requestStack;
    // permet de gerer toute les session 

    private EntityManagerInterface $em;
    // $em = entity manager 

    public function __construct(RequestStack $requestStack, EntityManagerInterface $em)
    {                              // RequestStack "type" la variable $requestStack : rien d'autre ne peut etre envoyer 
        // injection de dependances 
        // $this recupere la propriéte de la classe 
        $this->requestStack = $requestStack;

        $this->em = $em;
    }

    public function getSession(): SessionInterface // -> type de reponse de notre fonction 
    {
        return $this->requestStack->getSession();
    }


    public function addCart(int $id)
    {
        // récupération du tableau de produits ajoutés au panier depuis la session 
        // utilisateur 
        $cart = $this->getSession()->get('cart', []);

        // vérifier si le produit existe deja dans le panier 
        if (!empty($cart[$id])) {
            # si le produit existe, on incrémente la quantité 
            $cart[$id]++;
        } else {
            // sinon on ajoute le produit dans le panier 
            $cart[$id] = 1;
        }

        // mise à jour du panier dans la session utilisateur 
        $this->getSession()->set('cart', $cart);
    }

    // get pour recupere, set pour modifier 

    public function getTotal()
    {

        // récuperation du tableau de produits ajoutés au panier depuis la session utilisateur 
        $cart = $this->getSession()->get('cart');
        $cartData = []; // permet de récuperer la quantite des produits 

        if ($cart) {
            foreach ($cart as $id => $q) {

                // récupération du produit à partir de son id en bdd 
                $fetchArticles = $this->em->getRepository(Articles::class)->findOneBy(['id' => $id]);
                if ($fetchArticles) {
                    $cartData[] = [
                        'produits' => $fetchArticles,
                        'quantity' => $q
                    ];
                }
            }
        }

        // return le tableau de produits avec leurs informations et quantités 
        return $cartData;
    }


    public function deleteCart(int $id)
    {
        // récupération du tableau de produits ajoutés au panier depuis la session utilisteur 
        $cart = $this->getSession()->get('cart', []); 

        // suppression du produit 
        unset($cart[$id]);
        return $this->getSession()->set('cart', $cart);
    }


    public function deleteAllCart()
    {

        return $this->getSession()->remove('cart');
    }

    public function decrease(int $id)
    {       
        //récupération du tableau de produits ajoute au panier depuis la session utilisateur 


        $cart = $this->getSession()->get('cart', []);
        // vérification si la quantité du produits est supérieur a 1 pour pouvoir décrémenter

        if ($cart[$id] > 1) 
        {
           $cart[$id]--; 
        }
        else 
        {
            // si la quantite du produit est égale a 1, on supprime le produit du panier 
            
            unset($cart[$id]);
        }

        return $this->getSession()->set('cart', $cart);
    }
}