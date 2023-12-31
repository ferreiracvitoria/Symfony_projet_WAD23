<?php
// src/Service/GoogleBooksService.php

// namespace App\Service;

// use Symfony\Contracts\HttpClient\HttpClientInterface;

// class BooksService
// {
//     private $httpClient;
//     private $apiKey;

//     public function __construct(HttpClientInterface $httpClient, string $apiKey)
//     {
//         $this->httpClient = $httpClient;
//         $this->apiKey = $apiKey;
//     }

//     public function searchBookByTitle(string $title)
//     {
//         $url = "https://www.googleapis.com/books/v1/volumes?key=AIzaSyCEMpJ2nrwxZuxtHorXdZ_AYey3x7-vF6c";
//         try {
//             $response = $this->httpClient->request('GET', $url);
//             $data = $response->toArray();

//             return $data;
//         } catch (\Exception $e) {
//             return ['error' => $e->getMessage()];
//         }
//     }
// }
namespace App\Service;

use App\Entity\Livre;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class LivreService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function ajouterLivre(Livre $livre, User $utilisateur)
    {
        // Assurez-vous que la relation ManyToMany entre User et Livre est configurée correctement
        // dans les entités User et Livre.

        // Ajoutez le livre à la liste des livres lus par l'utilisateur.
        $utilisateur->addLivresLu($livre);

        // Persistez les modifications dans la base de données.
        $this->entityManager->flush();
    }
}
