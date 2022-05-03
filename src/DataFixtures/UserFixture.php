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

        // TODO créer un nouvel utilisateur user
        $newUser = new User();
        // TODO renseigner toutes les propriétés
        $newUser->setUserLastname($faker->unique()->lastName())
                ->setUserFirstname($faker->firstName())
                ->setUserAdress($faker->address())
                ->setUserBirthdate(new DateTime())
                ->setUserPassword('user')// TODO hasher le password
                ->setUserRole('ROLE_USER')
                ->setUserMail('user@user.com')
                ->setUserPhone($faker->phoneNumber())
                ->setUserCreatedAt(new DateTime());
        // TODO persist
        $manager->persist($newUser);

        // TODO créer un nouvel utilisateur admin
        $newUserAdmin = new User();
        // TODO renseigner toutes les propriétés
        $newUserAdmin->setUserLastname($faker->unique()->lastName())
                ->setUserFirstname($faker->firstName())
                ->setUserAdress($faker->address())
                ->setUserBirthdate(new DateTime())
                ->setUserPassword('admin')// TODO hasher le password
                ->setUserRole('ROLE_ADMIN')
                ->setUserMail('admin@admin.com')
                ->setUserPhone($faker->phoneNumber())
                ->setUserCreatedAt(new DateTime());
        // TODO persist
        $manager->persist($newUserAdmin);

        
        $manager->flush();
    }
}
