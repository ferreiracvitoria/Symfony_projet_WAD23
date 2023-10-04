<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GenreController extends AbstractController
{
    #[Route('/genre/list', name: 'list_genres')]
    public function listGenres(): Response
    {
        // cette action affiche les genres averc de checkbox

            // chercher les genres

            // envoyer genres a vue , les afficher dans la vue

        return $this->render('genre/list_genres.html.twig');
    }
}
