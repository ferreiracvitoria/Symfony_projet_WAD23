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
        
        $faker = Faker\Factory::create();
        // $user1 = $manager->getRepository(User::class)->findOneBy(['nom' => 'utilisateur1']);
        // $livre1 = $manager->getRepository(Livre::class)->findOneBy(['title' => 'Titre du livre 1']);
        for ($i=0; $i < 10; $i++){
            $review = new Review(
                [
                    'rating' => $faker->numberBetween(1,5),
                    'commentaire' => $faker->text(),
                    'dateReview' => $faker->dateTime(),
                ]
            );
            $manager->persist($review);
        }
        $manager->flush();
    }
}
