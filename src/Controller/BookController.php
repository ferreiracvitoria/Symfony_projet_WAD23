<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Entity\Review;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ActivityRepository;
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

    #[Route('/review/submit', name: 'review_submit')]
    public function reviewSubmitAction(Request $req, EntityManagerInterface $em, ActivityRepository $aRep, ManagerRegistry $doctrine): Response {
 
        $activity = $aRep->find($req->request->get('activity_id'));
        //reviewform
        $review = new Review();
        $formReview = $this->createForm(ReviewType::class, $review, ['method' => 'POST']);
        $formReview->handleRequest($req);
 
        if ($formReview->isSubmitted()) {
            
            // Retrieve the rating and comment from the Symfony form
            $rating = $req->request->get('rating');
            $commentaire = $formReview->get('commentaire')->getData();
 
            // Set the rating and comment in your review entity
            $review->setRating($rating);
            $review->setCommentaire($commentaire);
            // Set dateReview to the current date and time
            $dateReview = new \DateTime();
            $review->setDateReview($dateReview);
 
            //associate the review with the user who logged in
            $user = $this->getUser();
            $review->setUser($user);
 
            // Get the entity manager and persist the review
            $em = $doctrine->getManager();
            $em->persist($review);
            $em->flush();
 
            // Redirect to the review submit page (adjust the route as needed)s
            return $this->render('/review_submit.html.twig');
        }
    }
}
