<?php

namespace App\DataFixtures;

use App\Entity\Genre;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;;

class GenreFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        
        $genres = [
            "Fantasy", 
            "Adventure", 
            "Romance", 
            "Contemporary", 
            "Dystopian",  
            "Mystery",  
            "Horror",  
            "Thriller",  
            "Science Fiction", 
            "Children", 
            "History", 
            "Self-help", 
            "Humor", 
            "Art", 
            "Poetry",
        ];

        for($i = 0; $i < 10; $i++){

            $randomGenreIndex = mt_rand(0, count($genres)-1);
            $randomGenre = $genres[$randomGenreIndex];
            
            $genre = new Genre (
                [
                    'genreName'=> $randomGenre,
                ]
                );
            $manager->persist($genre);
        }
        $manager->flush();
    }

    public function loadGenresArray(): array
    {

        return [
            "Fantasy", 
            "Adventure", 
            "Romance", 
            "Contemporary", 
            "Dystopian",  
            "Mystery",  
            "Horror",  
            "Thriller",  
            "Science-Fiction", 
            "Children", 
            "History", 
            "Self-help", 
            "Humor", 
            "Art", 
            "Poetry",
        ];
    }
}