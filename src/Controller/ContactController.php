<?php

namespace App\Controller;

use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends MyController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer, EntityManagerInterface $manager): Response
    {


       $form = $this->createForm(ContactType::class);

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){

                $data = $form->getData();
                $mail = $data['email'];
                $message = $data['message'];

                $email = (new Email())
            ->from($mail)
            ->to('neal973@live.fr')
            ->subject('Demande de contact')
            ->text($message);
            
            $mailer->send($email);
            $manager->flush();

            $this->addFlash("success", "Votre message a bien été envoyé");
            return $this->redirectToRoute("app_contact");

            }

        return $this->renderForm('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'formulaire' => $form
        ]);
    }
}
