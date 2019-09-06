<?php

namespace App\DataFixtures;


use Faker;

use App\Entity\User;
use App\Entity\Serie;
use App\Entity\Season;
use App\Entity\Episode;
use App\Entity\Category;
use App\Entity\Commentary;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
 
class FakerFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
 
        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        /*tableau de nos categories*/

        $categories = ['action', 'aventure' , 'science-fiction' , 'drame', 'biopics', 'fantastique', 'anim', 'comédie' ,'historique', 'espionnage','thriller', 'comédie musicale', 'horreur', 'politique' ];

        /* On génere des categories dans la table catégories */

        foreach ( $categories as $categorie) 
        {
            $cat = new Category;
            $cat->setType($categorie);
            $manager->persist($cat);
        }

        $manager->flush();

        /* On recupere la liste de nos series saisons, episode pour leurs atribuer une ou plusieurs prorpiétés*/

        $repository = $manager ->getRepository(Serie::class);
        $series = $repository ->findAll();
        $countS = count($series);

        $repository = $manager->getRepository(Season::class);
        $seasons = $repository ->findAll();
        $countSea = count($seasons);

        $repository = $manager->getRepository(Episode::class);
        $episodes = $repository ->findAll();
        $countE = count($episodes);

        /*attribution des categories à serie*/

        foreach($series as $serie)
        {   

            $counter = rand(0,5);

            for($i=0; $i <= $counter; $i++){
                $randCat = $faker->randomElement($categories);
                if (!in_array($randCat,$serie->getCategories()))
                {
                    $serie->addCategory($randCat);
                    $manager->persist($serie);
                }
            }
        }

        $manager->flush();

       
                    
 
        // on créé 50 personnes
        for ($i = 0; $i < 50; $i++) 
        {
            $user = new User();
            $user -> setUsername($faker -> userName);
            $user -> setPassword('$argon2i$v=19$m=65536,t=4,p=1$VmFmVDdsdEQ2VjZkSlFyVA$k8Lm6kkt05XvlnMFX2NAkQ1G3tKanpnfQfuIjRQKGp0');
            $user -> setEmail($faker -> email);
            $user -> setFirstName($faker -> firstName($gender = 'male'|'female'));
            $user -> setLastName($faker -> lastName);
            $user -> setKind($faker -> randomElement(['m', 'f', 't']));
            $user -> setLocation($faker -> country);
            $user -> setBirthDate($faker -> dateTimeThisCentury($max = 'now', $timezone = null));
            $user -> setNewsletter($faker -> boolean);
            $manager -> persist($user);
        }

        $manager->flush();

         /* On recupere la liste de nos membres pour leurs atribuer une ou plusieurs commentaires*/

         $repository = $manager ->getRepository(User::class);
         $users = $repository ->findAll();
         $countU = count($users);

        $limit = rand(0,5);

        foreach ($users as $user)
        {

            $counter= rand(0,4  );

            for ($i=0 ; $i <= $counter ; $i++)
            {

            $comment = new Commentary;
            $comment -> setIdUser($user);
            $counterItem = rand (0, 2);


            // if ($counterItem == 0)
            // {
               // $comment -> setIdSerie($series[rand(1, $countS)]);
            // }
            // elseif ($counterItem == 1)
            // {
            //     $comment -> setIdSeason($seasons[rand(0,$countSea)]);
            // }
            // else
            // {
            //     $comment -> setIdEpisode($episodes[rand(0,$countE)]);
            // }



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
        }

        $manager->flush();


    }
}


?>