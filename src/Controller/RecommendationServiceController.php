<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecommendationServiceController extends AbstractController
{
    #[Route('/recommendation/service', name: 'app_recommendation_service')]
    public function findSimilary(ManagerRegistry $doctrine, $livre): Response
    {
        $livres = $doctrine->getRepository(Livre::class);
        $arrayLivres = $livres->findAll();

        // faire la compairaison 

        // endregion


        // $similarites[] =['livre' => $livre, 'valSim'=>$similarite];
        
        // Define a custom comparison function
        function customSort($livre1, $livre2) {
            if ($livre1['valSim'] == $livre2['valSim']) {
                return 0;
            }
            return ($livre1['valSim'] > $livre2['valSim']) ? -1 : 1;
        }
        
        usort($array, 'customSort');
        
        print_r($array);

        return $this->render('recommendation_service/findSimilary.html.twig', );
    }
}
