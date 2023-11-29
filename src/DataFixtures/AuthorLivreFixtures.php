<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Livre;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
;

class AuthorLivreFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        //1. Obtenir tous les livres
        $livres = $manager->getRepository(Livre::class);
        $arrayLivres = $livres->findAll();

        //2. Obtenir tous les auteurs
        $authors = $manager->getRepository(Author::class);
        $arrayAuthors= $authors->findAll();

        //3. Parcourir les auteurs, pour chaque user, rajouter un livre aléatoire
        foreach($arrayAuthors as $author){
            $randomIndex = array_rand($arrayLivres);
            $author->addOwn($arrayLivres[$randomIndex]); 
            $manager->persist($author);
        }
        $manager->flush();
    }

    //4. fixer les dépendances de cette fixture
    public function getDependencies(): array
    {
        return[
            LivreFixtures::class,
            AuthorFixtures::class
        ];
    }
}
