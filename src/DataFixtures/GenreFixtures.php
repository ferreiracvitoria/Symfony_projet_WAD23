<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Genre;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
;

class GenreFixtures extends Fixture
{
    
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();
        for($i = 0; $i < 10; $i++){
            $genre = new Genre(
                [
                    'genreName' => $faker->word(),
                ]
            );
            $manager->persist($genre);
        }
        $manager->flush();
    }
}