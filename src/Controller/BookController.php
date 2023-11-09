<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Livre;
use App\Entity\Review;
use App\Form\BookType;
use App\Form\ReviewType;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookController extends AbstractController
{
    #[isGranted('ROLE_USER')]
    #[Route('/Our/Books', name:"all_books")]
    public function arrayLivres(ManagerRegistry $doctrine)
    {
        // Fetch the list of books from your fixture or data source
        $livres = $doctrine->getRepository(Livre::class);
        $arrayLivres = $livres->findAll();



        $vars = ['arrayLivres' => $arrayLivres];

        return $this->render('rubriques/all_the_books.html.twig', $vars);
    }

    #[Route("/rechercher-livre", name:"rechercher_livre")]
    public function rechercherLivre(Request $request, LivreRepository $livreRepository)
    {
        $form = $this->createForm(BookType::class, null, ['method' => 'POST']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $titre = $form->get('titre')->getData();
            $livre = $livreRepository->rechercherParTitre($titre);

            return $this->render('rubriques/list_user.html.twig', ['livre' => $livre, 'form' => $form->createView()]);
        }

        return $this->render('rubriques/list_user.html.twig', ['form' => $form->createView()]);
    }

    #[Route("/ajouter-livre/{id}", name:"ajouter_livre")]
    public function ajouterLivre(Livre $livresLu, EntityManagerInterface $entityManager)
    {
        $user = $this->getUser();
        $livresLus = $this->getLivresLus();

        // Assurez-vous que le livre n'est pas déjà dans la liste de recommandations de l'utilisateur
        if (!$user->$livresLus->contains($livresLu)) {
            $user->LivresLus->add($livresLu);
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Le livre a été ajouté à votre liste de recommandations.');
        } else {
            $this->addFlash('warning', 'Le livre est déjà dans votre liste de recommandations.');
        }

        return $this->redirectToRoute('liste_recommandations');
    }

    // #[Route('/review/submit{id}', requirements: ['id' => '\d+'], name: 'review_submit')]
    // public function reviewSubmitAction(Request $request, EntityManagerInterface $em, ManagerRegistry $doctrine, LivreRepository $livreRep): Response {

        
    //     //reviewform
    //     $review = new Review();
    //     $formReview = $this->createForm(ReviewType::class, $review, ['method' => 'POST']);
    //     $formReview->handleRequest($request);
        
    //     //associate the review with the book read
    //     $id = $request->get('id');
    //     $review = $livreRep->find($id);
        
    //     //associate the review with the user who logged in
    //     $review = $this->getUser();

    //     if ($formReview->isSubmitted() && $formReview->isValid()) {
            
    //         // Retrieve the rating and comment from the Symfony form
    //         $rating = $request->request->get('rating');
    //         $commentaire = $formReview->get('commentaire')->getData();

    //         // Set the rating and comment in your review entity
    //         $review->setRating($rating);
    //         $review->setCommentaire($commentaire);

    //         // Set dateReview to the current date and time
    //         $dateReview = new \DateTime();
    //         $review->setDateReview($dateReview);

            
    //         // Get the entity manager and persist the review
    //         $em = $doctrine->getManager();
    //         $em->persist($review);
    //         $em->flush();
            
    //         // Redirect to the review submit page (adjust the route as needed)s
    //         return $this->render('/review_submit.html.twig', [
    //             'formReview' => $formReview->createView(),
    //         ]);
    //     }
    // }
}
