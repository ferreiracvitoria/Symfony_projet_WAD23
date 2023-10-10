<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Livre;
use App\Entity\Lecture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
;

// class LectureFixtures extends Fixture
// {
//     public function load(ObjectManager $manager): void
//     {
//         $livre = $manager->getRepository(Livre::class);
//         $livres = $livre->findAll();

//         $user = $manager->getRepository(User::class);
//         $users = $user->findAll();
        
//         // $lecture = new Lecture();
//         $lecture->setUser($users);
//         $lecture->setLivre($livres);
        
//         $manager->persist($lecture);

//         $manager->flush();
//     }
// }
