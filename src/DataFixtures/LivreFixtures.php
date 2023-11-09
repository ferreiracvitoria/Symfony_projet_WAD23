<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Livre;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
;

class LivreFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = Faker\Factory::create();
        for ($i = 0; $i < 10; $i++){
            $livre = new Livre(
                [
                    'titre' => $faker->word(3),
                    'isbn' => $faker->isbn10(),
                    'isbn' => $faker->isbn13(),
                    'numberPages' => $faker->numberBetween(),
                    'dateEdition' => $faker->dateTime(),
                    'resume' => implode (" ",array_merge ($faker->words(6), ['et voici la partie qui est pareille'])),
                    'thumbnail' => $faker->imageUrl(200, 300),
                    'smallThumbnail'=> $faker->imageUrl(100, 150)
                    
                ]
            );
            $manager->persist($livre);
        }
        $manager->flush();
    }
}
