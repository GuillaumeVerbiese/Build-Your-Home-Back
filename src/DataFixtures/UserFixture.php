<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixture extends Fixture
{
    
    public function load(ObjectManager $manager): void
    {
        // TODO récupérer faker
        $faker = Factory::create('fr-FR');

        // TODO boucler pour en créer 20
        for ($i=0; $i < 20 ; $i++) {

            // TODO créer un nouvel utilisateur
            $newUser = new User();
            // TODO renseigner toutes les propriétés
            $newUser->setUserLastname($faker->unique()->lastName())
                    ->setUserFirstname($faker->firstName())
                    ->setUserAdress($faker->address())
                    ->setUserBirthdate(new DateTime());
        
            //? hasher le mot de passe
            // TODO persist
        }

        $manager->flush();
    }
}
