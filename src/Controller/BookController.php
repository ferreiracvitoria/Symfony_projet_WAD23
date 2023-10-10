<?php

namespace App\Controller;

use App\Entity\Livre;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookController extends AbstractController
{
    
    #[Route('/home/accueil', name:"afficher_livres")]
    public function arrayLivres(ManagerRegistry $doctrine)
    {
        // Fetch the list of books from your fixture or data source
        $livres = $doctrine->getRepository(Livre::class);
        
        $arrayLivres = $livres->findAll();

        $vars = ['arrayLivres' => $arrayLivres];

        return $this->render('home/accueil.html.twig', $vars);
    }

}
