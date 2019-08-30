<?php

namespace App\DataFixtures;
 
use Faker;

use App\Entity\User;
use App\Entity\Commentary;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
 
class FakerFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
 
        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');
 
        // on créé 10 personnes
        for ($i = 0; $i < 50; $i++) 
        {
            $user = new User();
            $user -> setUsername($faker -> userName);
            $user -> setPassword('$argon2id$v=19$m=65536,t=4,p=1$amxqZXdEekJuaEFLWHpLWQ$ncGqO3KdTi6qLpEDiiP6JpksPGqunIKWZNleC9x4EQI');
            $user -> setEmail($faker -> email);
            $user -> setFirstName($faker -> firstName($gender = 'male'|'female'));
            $user -> setLastName($faker -> lastName);
            $user -> setKind($faker -> randomElement(['m', 'f', 't']));
            $user -> setLocation($faker -> country);
            $user -> setBirthDate($faker -> dateTimeThisCentury($max = 'now', $timezone = null));
            $user -> setNewsletter($faker -> boolean);
            $manager -> persist($user);



            $limit = rand(0,5);

            for ($j = 0;$j < $limit; $j++)
            {
                $comment = new Commentary;
                $comment -> setIdUser($user);
                if($faker -> boolean == 0)
                {
                    $comment -> setRating(NULL);
                }
                else
                {
                    $comment -> setRating($faker -> boolean);
                }
                $comment -> setSpoil($faker -> boolean);
                
                $comment -> setContent($faker ->  text($maxNbChars = 200));
                $manager -> persist($comment);
            }

        $manager->flush();


        }
    }
}

?>