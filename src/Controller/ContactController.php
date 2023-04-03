<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request,MailerInterface $mailer): Response   // permet de recuperer les données
    {

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request); // recupere les données

        if($form->isSubmitted() && $form->isValid()){
         $adresse = $form->get('email')->getData();
         $sujet = $form->get('sujet')->getData();
         $recommandation = $form->get('Recommandation_article_ou_message')->getData();
         $contenu = $form->get('contenu')->getData();

         $email = (new Email())
         ->from($adresse)
         ->to('admin@admin.com')
         ->subject($sujet)
         
         ->text($recommandation);


         $mailer->send($email);

         return $this->redirectToRoute('app_sucess');
        }
        return $this->renderForm('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'form' => $form
        ]);
    }
    #[Route('/contact/sucess', name: 'app_sucess')]
    public function sucess(): Response
    {
        return $this->render('sucess/index.html.twig', [
            'controller_name' => 'SucessController',
        ]);
    }
}
