<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\User;
use App\Entity\Livre;
use App\Entity\Review;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

;

class ReviewFixtures extends Fixture implements DependentFixtureInterface
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

            $bookChoise = $livres[array_rand($livres)];
            $userChoise = $users[array_rand($users)];
            
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
            $review->setLivres($bookChoise);
            $review->setUsers($userChoise);

            $manager->persist($review);
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return ([
            UserFixtures::class,
            LivreFixtures::class
        ]);
    }
}
