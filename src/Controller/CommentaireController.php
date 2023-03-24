<?php

namespace App\Controller;

use App\Entity\User;
use DateTimeImmutable;
use App\Entity\Article;
use App\Entity\Commentaire;
use App\Form\Commentaire1Type;
use App\Repository\CommentaireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/article/{id}/commentaire')]
class CommentaireController extends AbstractController
{
  

    #[Route('/new', name: 'app_commentaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request,Article $article, CommentaireRepository $commentaireRepository): Response
    { // Param converter sa permet de passer d'un ID dans une URL a directement la recuperation en BDD
        $commentaire = new Commentaire();
        $commentaire->setCreatedAt(new DateTimeImmutable());
        $commentaire->setPseudo($this->getUser());    // sa correspond au Pseudo de l'entité commentaire  
        $commentaire->setArticle($article);

        $form = $this->createForm(Commentaire1Type::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaireRepository->save($commentaire, true);

            return $this->redirectToRoute('app_article_show', [
                'id' => $article->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commentaire/new.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form,
        ]);
    }
}
