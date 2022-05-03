<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\DeliveriesFees;
use App\Entity\Order;
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

        $categoriesList = [];
        $categoryNameList = ["electroménager","image","son","téléphone","console","gaming","cuisine","informatique","tablette","jardin","beauté","santé"];
        for ($i=1; $i < 10; $i++) { 

            // TODO créer une nouvelle categorie
            $newCategory = new Category();
            // TODO renseigner toutes les propriétés
            $name = $categoryNameList[$i];
            $newCategory->setCategoryName($name)
            ->setCategoryPictureLink('https://picsum.photos/id/'.rand(500,1000).'/200/300')
            ->setCategorySlug($name)
            ->setCategoryDisplayOrder($i<=5?$i:0)
            ->setCategoryCreatedAt(new DateTime());
            // TODO persist
            $manager->persist($newCategory);
            // TODO l'ajouter à la liste
            $categoriesList[] = $newCategory;
        }

        $deliveryFeesList = [];
        $deliveryNameList = ["petit","moyen","gros"];
        for ($i=0; $i < 3; $i++) { 

            // TODO créer un nouveau frais de livraison
            $newDeliveryFees = new DeliveriesFees();
            // TODO renseigner toutes les propriétés
            $name = $deliveryNameList[$i];
            $newDeliveryFees->setDeliveryFeesName($name)
                            ->setDeliveryFeesPrice(($i+1)*10)
                            ->setDeliveryFeesCreatedAt(new DateTime());
            // TODO persist
            $manager->persist($newDeliveryFees);
            // TODO l'ajouter à la liste
            $deliveryFeesList[] = $newDeliveryFees;
        }

        for ($i=0; $i < 20; $i++) { 
            
            // TODO créer une nouvelle commande
            $newOrder = new Order();
            // TODO renseigner toutes les propriétés
            $newOrder->setOrderStatus(rand(0,2))
            ->setOrderUser($i%2==0?$newUser:$newUserAdmin)
            ->setOrderDeliveries($deliveryFeesList[rand(0,count($deliveryFeesList)-1)])
            ->setOrderCreatedAt(new DateTime());
            // TODO persist
            $manager->persist($newOrder);
        }


        $manager->flush();
    }
}
