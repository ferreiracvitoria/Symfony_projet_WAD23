<?php
// src/Service/GoogleBooksService.php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class BooksService
{
    private $httpClient;
    private $apiKey;

    public function __construct(HttpClientInterface $httpClient, string $apiKey)
    {
        $this->httpClient = $httpClient;
        $this->apiKey = $apiKey;
    }

    public function searchBookByTitle(string $title)
    {
        $url = "https://www.googleapis.com/books/v1/volumes?key=AIzaSyCEMpJ2nrwxZuxtHorXdZ_AYey3x7-vF6c";
        try {
            $response = $this->httpClient->request('GET', $url);
            $data = $response->toArray();

            return $data;
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}