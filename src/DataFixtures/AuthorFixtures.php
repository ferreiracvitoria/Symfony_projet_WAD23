<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Author;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class AuthorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++){
            $author = new Author(
                [
                    'nom' => $faker->lastName(),
                    'prenom' => $faker->firstName(),
                    'biographie'=> $faker->text(),
                ]
            );
            $manager->persist($author);

        }

        $manager->flush();
    }
}
