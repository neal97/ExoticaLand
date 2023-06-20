<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\ProfilType;
use App\Controller\MyController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProfilController extends MyController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(): Response
    {




        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
        ]);
    }


    




     // Update 
     #[Route('/profil_update/{id}', name: 'profil_update')]

     public function profil(User $user, Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $userPasswordHasher)
     {
         
         $form = $this->createForm(ProfilType::class, $user);
 
         $form->handleRequest($request);
 
         if ($form->isSubmitted() && $form->isValid()) {
             $user->setPassword(
                 $userPasswordHasher->hashPassword(
                     $user,
                     htmlspecialchars(
                         $form->get('plainPassword')->getData()
                     )
                 )
             );
     
             $manager->persist($user);
             $manager->flush();
 
             
             $this->addFlash("Succès", "L'utilisateur N°" . $user->getId() . " a bien été modifié ! 🥷🏽");
 
             return $this->redirectToRoute('app_profil');
         }
 
         return $this->render("profil/update.html.twig", [
             'controller_name' => 'ProfilUpdate',
             "formProfil" => $form->createView(),
             "user" => $user
         ]);
     }


}
