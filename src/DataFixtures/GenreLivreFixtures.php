<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use App\Entity\Livre;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
;

class GenreLivreFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $livres = $manager->getRepository(Livre::class);
        $arrayLivres = $livres->findAll();

        $genres = $manager->getRepository(Genre::class);
        $arrayGenres= $genres->findAll();

        foreach($arrayGenres as $genre){
            $randomIndex = array_rand($arrayLivres);
            $genre->addClassify($arrayLivres[$randomIndex]); 
            $manager->persist($genre);
        }
        $manager->flush();
    }

    //4. fixer les dépendances de cette fixture
    public function getDependencies(): array
    {
        return[
            LivreFixtures::class,
            GenreFixtures::class
        ];
    }
}
