<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

    #[Route('/review/submit{id}', requirements: ['id' => '\d+'], name: 'review_submit')]
    public function reviewSubmitAction(Request $request, EntityManagerInterface $em, ManagerRegistry $doctrine, LivreRepository $livreRep): Response {

        
        //reviewform
        $review = new Review();
        $formReview = $this->createForm(ReviewType::class, $review, ['method' => 'POST']);
        $formReview->handleRequest($request);
        
        //associate the review with the book read
        // $id = $request->get('id');
        // $review = $livreRep->find($id);
        
        //associate the review with the user who logged in
        $review = $this->getUser();

        if ($formReview->isSubmitted() && $formReview->isValid()) {
            
            // Retrieve the rating and comment from the Symfony form
            $rating = $request->request->get('rating');
            $commentaire = $formReview->get('commentaire')->getData();

            // Set the rating and comment in your review entity
            $review->setRating($rating);
            $review->setCommentaire($commentaire);

            // Set dateReview to the current date and time
            $dateReview = new \DateTime();
            $review->setDateReview($dateReview);

            
            // Get the entity manager and persist the review
            $em = $doctrine->getManager();
            $em->persist($review);
            $em->flush();
            
            // Redirect to the review submit page (adjust the route as needed)s
            return $this->render('/review_submit.html.twig', [
                'formReview' => $formReview->createView(),
            ]);
        }
    }
}
