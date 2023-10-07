<?php

namespace App\Controller;

use App\Service\BooksService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/book', name: 'app_book')]

class BookController extends AbstractController
{
    public function books(BooksService $BooksService)
    {
        $title = 'Symfony'; // Titre du livre à rechercher

        $bookData = $BooksService->searchBookByTitle($title);

        return $this->render('book/books.html.twig', [
            'bookData' => $bookData,
        ]);
    }
}
