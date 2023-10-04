<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\User;
use App\Entity\Livre;
use App\Entity\Review;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
;

class ReviewFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // on obtient tous les commandes. Pour chaque Evenement on fixera un User random
        $livre = $manager->getRepository(Livre::class);
        $livres = $livre->findAll();

        $user = $manager->getRepository(User::class);
        $users = $user->findAll();
        
        
        $faker = Faker\Factory::create();
        for ($i=0; $i < 10; $i++){

            $bookChoise = $livres[rand(0, count($livres) - 1)];
            $userChoise = $users[rand(0, count($users) - 1)];
            
            $review = new Review(
                [
                    'rating' => $faker->numberBetween(1,5),
                    'commentaire' => $faker->text(),
                    'dateReview' => $faker->dateTime(),
                ]
                // [
                //     'rating' => $faker->numberBetween(1,5),
                //     'commentaire' => $faker->text(),
                //     'dateReview' => $faker->dateTime(),
                // ]
            );
            $review->setLivres($livres);
            $review->setUsers($users);

            $manager->persist($review);
        }
        $manager->flush();
    }
}
