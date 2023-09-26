<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class HomeController extends AbstractController{

    #[isGranted('ROLE_USER')]
    #[Route ('/', name:'home')]
    public function home (){
        return $this->render ('home/accueil.html.twig');
    } 


}
