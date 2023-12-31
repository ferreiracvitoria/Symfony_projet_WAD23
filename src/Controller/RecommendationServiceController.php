<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Repository\LivreRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use NlpTools\Similarity\CosineSimilarity; //imports de nlp-tools
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecommendationServiceController extends AbstractController
{
    #[Route('/recommendation/service', name: 'app_recommendation_service')]
    public function findSimilarity(ManagerRegistry $doctrine, LivreRepository $rep): Response
    {


        $livres = $doctrine->getRepository(Livre::class);
        $arrayLivres = $livres->findAll();


        $cosine = new CosineSimilarity();
        $tokenizer = new \NlpTools\Tokenizers\WhitespaceTokenizer();

        $similarities = [];

        // Comparaison de chaque livre avec tous les autres livres
        foreach ($livres as $livre) {
            $currentSimilarities = [];

            foreach ($livres as $otherLivre) {
                if ($livre !== $otherLivre) {
                    $tokens1 = $tokenizer->tokenize($livre->getResume());
                    $tokens2 = $tokenizer->tokenize($otherLivre->getResume());

                    $similarity = $cosine->similarity($tokens1, $tokens2);

                    $currentSimilarities[] = [
                        'livre' => $otherLivre,
                        'valSim' => $similarity,
                    ];
                }
            }

            $similarities[$livre->getId()] = $currentSimilarities;
        }

        return $this->render(
            'recommendation_service/find_similarity.html.twig',
            [
                
                'similarities' => $similarities,
            ]
        );
    }

    #[Route('/rubrique/recommendation/{livre}', name: 'app_recommendation_rubrique')]
    public function rubriqueRecommandation(ManagerRegistry $doctrine, Livre $livre): Response
    {
        $livres = $doctrine->getRepository(Livre::class); // Importer le Livre ici
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

        // similarite minimale
        $min = 0.6;

        $arrObjLivresChoisis = [];
        foreach ($similarities as $arrLivreSim) {
            if ($arrLivreSim['valSim'] > $min) {

                $arrObjLivresChoisis[] = $arrLivreSim['livre'];
            }
        }

        // dd($arrObjLivresChoisis);

        return $this->render(
            'rubriques/all_the_books.html.twig',
            [
                'livre' => $livre,
                'similarities' => $arrObjLivresChoisis,
            ]
        );
    }
}
