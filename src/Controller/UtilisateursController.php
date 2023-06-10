<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UtilisateursController extends MyController
{
    #[Route('admin/utilisateurs', name: 'app_utilisateurs')]
    public function index(UserRepository $repoUser): Response
    {

        $user = $repoUser->findAll();
        

        return $this->render('utilisateurs/index.html.twig', [
            'controller_name' => 'UtilisateursController',
            'user' => $user
        ]);
    }




    #[Route('/utilisateurs/update/{id}', name: 'update_utilisateurs')]
    public function update_categorie($id, UserRepository $reposUser, Request $request, EntityManagerInterface $manager)
    {
        $user = $reposUser->find($id);
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($user);
            $manager->flush();

            $this->addFlash("success", "Utilisateur N°" . $user->getId() . " a bien été modifié");
            return $this->redirectToRoute("app_utilisateurs");
        }
        return $this->render("utilisateurs/update.html.twig",[
            "formUser" => $form->createView(),
            "user" => $user
        ]);
    }




    #[Route('/utilisateurs/delete/{id}', name: 'delete_utilisateurs')]
    public function delete(User $user, EntityManagerInterface $manager)
    {
      
            
       $id = $user->getId();

       $manager->remove($user);
       $manager->flush();

       $this->addFlash("Succes","l'utilisateurs' N°". $id . "a bien été supprimer");
       return $this->redirectToRoute("app_utilisateurs");
     

}


}
