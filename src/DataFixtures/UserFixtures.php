<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\User;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct (UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;

    }

    public function load(ObjectManager $manager): void
    {

        $faker = Faker\Factory::create();
        for($i=0; $i <= 20; $i++){
            $user = new User(
                [
                'nom' => $faker->lastName,
                'prenom' => $faker->firstName,
                'email' => 'user'.$i.'@gmail.com',
                'roles' => []
                ]
        );
        //fixer un password sans hasher
        $passwordSansHash = "monpassword";

        //Obtenir le password hashé
        $passwordHash = $this->passwordHasher->hashPassword($user,
        $passwordSansHash);

        // incruster dans l'entité le password hashé
        $user->setPassword($passwordHash);
        $manager->persist($user);

        }
        $manager->flush();
    }
}
