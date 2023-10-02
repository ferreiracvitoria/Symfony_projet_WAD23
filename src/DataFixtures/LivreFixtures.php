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
                    'titre' => $faker->text(),
                    'isbn' => $faker->text(),
                    'numberPages' => $faker->numberBetween(),
                    'dateEdition' => $faker->dateTime(),
                    'Resume' => $faker->text(),
                    'dateEdition' => $faker->dateTime()
                ]
            );
            $manager->persist($livre);
        }
        $manager->flush();
    }
}
