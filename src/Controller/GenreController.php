<?php

namespace App\Controller;

use App\Form\GenreType;
use App\DataFixtures\GenreFixtures;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GenreController extends AbstractController
{
    #[Route('/genres/list', name: 'list_genres')]
    public function listGenres(Request $request, GenreFixtures $genreFixtures): Response
    {
        $genresArray = $genreFixtures->loadGenresArray();
        // cette action affiche les genres averc de checkbox
        $formGenre = $this->createForm(GenreType::class, null, ['genre_choices' => $genresArray]);
        $formGenre->handleRequest($request);

            // chercher les genres
            if ($formGenre->isSubmitted() && $formGenre->isValid()) {
                $selectedGenres = $formGenre->get('genres')->getData();

                dump($selectedGenres);
            }

            // envoyer genres a vue , les afficher dans la vue
            $vars = ['formGenre' => $formGenre->createView()];

        return $this->render('genre/list_genres.html.twig', $vars);
    }
}
