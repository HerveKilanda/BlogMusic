<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

#[Route('/article')]
class ArticleController extends AbstractController
{
    
        #[Route('/{id}', name: 'app_article_show', methods: ['GET'])]
        public function show(Article $article): Response
        {
            
            $commentaires = $article->getCommentaires();
            return $this->render('article/show.html.twig', [
                'article' => $article,
                'commentaires' => $commentaires
                
                
            ]);
        }
}
