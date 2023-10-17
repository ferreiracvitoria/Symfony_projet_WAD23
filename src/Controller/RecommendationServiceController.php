<?php

namespace App\Controller;

use App\Entity\Livre;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use NlpTools\Similarity\CosineSimilarity; //imports de nlp-tools

class RecommendationServiceController extends AbstractController
{
    #[Route('/recommendation/service/{livre}', name: 'app_recommendation_service')] // Ajoutez un paramètre de livre
    public function findSimilarity(ManagerRegistry $doctrine, Livre $livre): Response
    {
        $livres = $doctrine->getRepository(Livre::class); // Assurez-vous que Livre est importé
        $arrayLivres = $livres->findAll();

        $cosine = new CosineSimilarity();

        $similarities = [];
        $tokenizer = new \NlpTools\Tokenizers\WhitespaceTokenizer();

        foreach ($arrayLivres as $otherLivre) {
            $tokens1 = $tokenizer->tokenize($livre->getResume());
            $tokens2 = $tokenizer->tokenize($otherLivre->getResume());

            $similarity = $cosine->similarity($tokens1, $tokens2);

            $similarities[] = [
                'livre' => $otherLivre,
                'valSim' => $similarity,
            ];
        }

        // Tri des livres en fonction de la similarité
        usort($similarities, function ($livre1, $livre2) {
            return $livre1['valSim'] <=> $livre2['valSim'];
        });

        return $this->render('recommendation_service/findSimilarity.html.twig', [
            'similarities' => $similarities,
        ]);
    }
}
