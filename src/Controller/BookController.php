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
    #[Route('/Our/Books', name: "all_books")]
    public function arrayLivres(Request $request, ManagerRegistry $doctrine, LivreRepository $livreRepository)
    {
        $form = $this->createForm(BookType::class, null, ['method' => 'POST']);
        $form->handleRequest($request);
        // Fetch the list of books from your fixture or data source
        $livres = $doctrine->getRepository(Livre::class);
        $arrayLivres = $livres->findAll();

        $vars = [
            'arrayLivres' => $arrayLivres,
            'form' => $form->createView()
        ];
        if ($form->isSubmitted() && $form->isValid()) {


            $titre = $form->get('titre')->getData();
            $livre = $livreRepository->rechercherParTitre($titre);
            $vars = [
                'livre' => $livre,
                'form' => $form->createView()
            ];
            return $this->render('rubriques/list_user.html.twig', $vars);
        } else {
            return $this->render('rubriques/all_the_books.html.twig', $vars);
        }
    }



    // //Recherche de livre par titre
    // #[Route("/rechercher-livre", name: "rechercher_livre")]
    // public function rechercherLivre(Request $request, LivreRepository $livreRepository)
    // {
    //     $form = $this->createForm(BookType::class, null, ['method' => 'POST']);
    //     $form->handleRequest($request);

    //     $livre = []; // Utilisez un tableau pour stocker tous les livre trouvés

    //     if ($form->isSubmitted() && $form->isValid()) {

    //         $titre = $form->get('titre')->getData();
    //         $livre = $livreRepository->rechercherParTitre($titre);
    //     }
    //     $user = $this->getUser();
    //     // dd($user,$livre);

    //     return $this->render('rubriques/list_user.html.twig', ['livre' => $livre]);
    // }

    #[Route("/ajouter-livre-favoris/{livreId}", name: "ajouter_livre_favoris")]
    public function ajouterLivreUtilisateur(Request $req, ManagerRegistry $doctrine,LivreRepository $livreRepository): Response
    {

        //gerer le form de recherche sue la pages de la liste des livres lus
        $form = $this->createForm(BookType::class, null, ['method' => 'POST']);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {


            $titre = $form->get('titre')->getData();
            $livre = $livreRepository->rechercherParTitre($titre);
            $vars = [
                'livre' => $livre,
                'form' => $form->createView()
            ];
            return $this->render('rubriques/list_user.html.twig', $vars);
        } else {
            //Obtenir le user Actuel
            $user = $this->getUser();
            // //obtenir le livre
            $id = $req->get('livreId');
            $entityManager = $doctrine->getManager();
            $rep = $entityManager->getRepository(Livre::class);

            $livre = $rep->find($id);

            // Ajoutez le livre à la liste de l'utilisateur (ajustez cela en fonction de votre logique métier)
            $user->addLivresLu($livre);


            // Persistez les changements dans la base de données
            $entityManager = $doctrine->getManager();
            $entityManager->flush();

            // Redirigez l'utilisateur vers la page des résultats de la recherche (ou une autre page de votre choix)
            $favorites = $user->getLivresLus();
            $vars = [
                'livre' => $favorites,
                'form' => $form->createView()
            ];
            // dd($vars, $livre);

            return $this->render('rubriques/ajout_lecture.html.twig', $vars);
        }
    }

    #[Route("/livre/detaille/{livreId}", name: "detaille_livre")]
    public function afficherDetailleLivre(Request $req, LivreRepository $rep, LivreRepository $livreRepository)
    {
        $form = $this->createForm(BookType::class, null, ['method' => 'POST']);
        $form->handleRequest($req);
        $id = $req->get('livreId');
        $livre = $rep->find($id);
        $vars = [
            'livre' => $livre,
            'form' => $form->createView()
        ];
        if ($form->isSubmitted() && $form->isValid()) {


            $titre = $form->get('titre')->getData();
            $livre = $livreRepository->rechercherParTitre($titre);
            $vars = [
                'livre' => $livre,
                'form' => $form->createView()
            ];
            return $this->render('rubriques/list_user.html.twig', $vars);
        } else {
            return $this->render('rubriques/afficher_detaille_livre.html.twig', $vars);
        }
    }





    
    #[Route("/afficher-livre-favoris", name: "afficher_list_livres_lus")]
    public function afficherLivreUtilisateur(Request $req, ManagerRegistry $doctrine,LivreRepository $livreRepository): Response
    {

        //gerer le form de recherche sue la pages de la liste des livres lus
        $form = $this->createForm(BookType::class, null, ['method' => 'POST']);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {


            $titre = $form->get('titre')->getData();
            $livre = $livreRepository->rechercherParTitre($titre);
            $vars = [
                'livre' => $livre,
                'form' => $form->createView()
            ];
            return $this->render('rubriques/list_user.html.twig', $vars);
        } else {
            //Obtenir le user Actuel
            $user = $this->getUser();
        

            // Redirigez l'utilisateur vers la page des résultats de la recherche (ou une autre page de votre choix)
            $favorites = $user->getLivresLus();
            $vars = [
                'livre' => $favorites,
                'form' => $form->createView()
            ];
            // dd($vars, $livre);

            return $this->render('rubriques/ajout_lecture.html.twig', $vars);
        }
    }


    // #[Route('/ajouter-livre/{userId}/{livreId}', name: 'ajouter_livre')]
    // public function ajouterLecture(EntityManagerInterface $entityManager, $userId, $livreId): Response
    // {
    //     // Récupérer l'utilisateur
    //     $user = $this->getUser();
    //     $user = $entityManager->getRepository(User::class)->find($userId);

    //     // Récupérer le livre
    //     $livre = $entityManager->getRepository(Livre::class)->find($livreId);

    //     // Vérifier si l'utilisateur et le livre existent
    //     if (!$user || !$livre) {
    //         throw $this->createNotFoundException('Utilisateur ou livre non trouvé.');
    //     }

    //     // Ajouter le livre à la liste des livres lus par l'utilisateur
    //     $user->addLivresLu($livre);

    //     // Enregistrer les modifications en base de données
    //     $entityManager->persist($user);
    //     $entityManager->flush();

    //     return $this->redirectToRoute('rubriques/ajout_lecture.html.twig');
    // }



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
