<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Livre;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
;

class RecommandationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        //1. Obtenir tous les livres
        $livres = $manager->getRepository(Livre::class);
        $arrayLivres = $livres->findAll();

        //2. Obtenir tous les users 
        $users = $manager->getRepository(User::class);
        $arrayUsers = $users->findAll();

        //3. Parcourir les users, pour chaque user, rajouter un livre aléatoire
        foreach($arrayUsers as $user){
            $randomIndex = array_rand($arrayLivres);
            $user->addLivresRecommande($arrayLivres[$randomIndex]); 
            $manager->persist($user);
        }
        $manager->flush();
    }

    //4. fixer les dépendances de cette fixture
    public function getDependencies(): array
    {
        return[
            LivreFixtures::class,
            UserFixtures::class
        ];
    }
}
