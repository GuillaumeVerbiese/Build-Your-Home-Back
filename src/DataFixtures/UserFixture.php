<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Order;
use App\Entity\Orderlist;
use DateTime;
use Faker\Factory;
use App\Entity\VAT;
use App\Entity\User;
use App\Entity\Brand;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Discount;
use App\Entity\DeliveriesFees;
use App\Entity\Favorite;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Constraints\Length;

class UserFixture extends Fixture
{

    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->passwordHasher = $hasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        
        // TODO récupérer faker
        $faker = Factory::create('fr-FR');

        // user
        // TODO créer un nouvel utilisateur user
        $newUser = new User();
        // On prepare le password
        $plaintextPassword = "user";
        // On le hash
        $hashedPassword = $this->passwordHasher->hashPassword($newUser,$plaintextPassword);
        // TODO renseigner toutes les propriétés
        $newUser->setLastname($faker->unique()->lastName())
                ->setFirstname($faker->firstName())
                ->setAdress($faker->address())
                ->setBirthdate(new DateTime())
                ->setPassword($hashedPassword)
                ->setRoles(['ROLE_USER'])
                ->setEmail('user@user.com')
                ->setPhone($faker->phoneNumber())
                ->setCreatedAt(new DateTime());
        // TODO persist
        $manager->persist($newUser);

        // TODO créer un nouvel utilisateur admin
        $newUserAdmin = new User();
        // On prepare le password
        $plaintextPassword = "admin";
        // On le hash
        $hashedPassword = $this->passwordHasher->hashPassword($newUserAdmin,$plaintextPassword);
        // TODO renseigner toutes les propriétés
        $newUserAdmin->setLastname($faker->unique()->lastName())
                ->setFirstname($faker->firstName())
                ->setAdress($faker->address())
                ->setBirthdate(new DateTime())
                ->setPassword($hashedPassword)
                ->setRoles(['ROLE_ADMIN'])
                ->setEmail('admin@admin.com')
                ->setPhone($faker->phoneNumber())
                ->setCreatedAt(new DateTime());
        // TODO persist
        $manager->persist($newUserAdmin);

        // category
        $categoriesList = [];
        $categoryNameList = ["electroménager","image","son","téléphone","console","gaming","cuisine","informatique","tablette","jardin","beauté","santé"];
        for ($i=1; $i < 10; $i++) { 

            // TODO créer une nouvelle categorie
            $newCategory = new Category();
            // TODO renseigner toutes les propriétés
            $name = $categoryNameList[$i];
            $newCategory->setName($name)
            ->setPicture('https://picsum.photos/id/'.rand(500,1000).'/200/300')
            ->setSlug($name)
            ->setDisplayOrder($i<=9?$i:0)
            ->setCreatedAt(new DateTime());
            // TODO persist
            $manager->persist($newCategory);
            // TODO l'ajouter à la liste
            $categoriesList[] = $newCategory;
        }

        // delivery fees
        $deliveryFeesList = [];
        $deliveryNameList = ["petit","moyen","gros"];
        for ($i=0; $i < 3; $i++) { 

            // TODO créer un nouveau frais de livraison
            $newDeliveryFees = new DeliveriesFees();
            // TODO renseigner toutes les propriétés
            $name = $deliveryNameList[$i];
            $newDeliveryFees->setName($name)
                            ->setPrice(($i+1)*10)
                            ->setCreatedAt(new DateTime());
            // TODO persist
            $manager->persist($newDeliveryFees);
            // TODO l'ajouter à la liste
            $deliveryFeesList[] = $newDeliveryFees;
        }

        // order
        $orderList = [];
        for ($i=0; $i < 20; $i++) { 
            
            // TODO créer une nouvelle commande
            $newOrder = new Order();
            // TODO renseigner toutes les propriétés
            $newOrder->setStatus(rand(0,2))
            ->setUser($i%2==0?$newUser:$newUserAdmin)
            ->setDeliveries($deliveryFeesList[rand(0,count($deliveryFeesList)-1)])
            ->setCreatedAt(new DateTime());
            // TODO persist
            $manager->persist($newOrder);
            $orderList[] = $newOrder;
        }

        // brand
        $brandList = [];
        $brandNameList = [
            "Belden",
            "Doodle Labs",
            "Festo",
            "Harwin",
            "Intel",
            "Lumileds",
            "Macronix",
            "Molex",
            "Nicomatic",
            "Ohmite",
            "PanaVise",
            "Quectel",
            "Rigado",
            "Sagrad",
            "Seek Thermal"
        ];
        for ($i = 0; $i < count($brandNameList); $i++) {
            $newBrand = new Brand();


            $newBrand->setname($brandNameList[$i])
                ->setSlug($brandNameList[$i])
                ->setCreatedAt(new Datetime)
                ->setUpdatedAt(new Datetime);

            $manager->persist($newBrand);
            $brandList[] = $newBrand;
        }

        // discount
        $discountList = [];
        for ($i = 0; $i < 20; $i++) {
            $newDiscount = new Discount();

            $newDiscount->setName($faker->word())
                ->setRate($i * 2)
                ->setCreatedAt(new Datetime)
                ->setUpdatedAt(new Datetime);

            $manager->persist($newDiscount);
            $discountList[] = $newDiscount;
        }
        
        // vat
        $VATList = [];
        for ($i = 0; $i < 3; $i++) {
            $newVAT = new VAT();

            if ($i == 0) {
                $newVAT->setName("taux normal")
                    ->setRate(20)
                    ->setCreatedAt(new Datetime)
                    ->setUpdatedAt(new Datetime);
            }
            if ($i == 1) {
                $newVAT->setName("taux intermediaire")
                    ->setRate(10)
                    ->setCreatedAt(new Datetime)
                    ->setUpdatedAt(new Datetime);
            }
            if ($i == 2) {
                $newVAT->setName("taux reduit")
                    ->setRate(5.5)
                    ->setCreatedAt(new Datetime)
                    ->setUpdatedAt(new Datetime);
            }
            $manager->persist($newVAT);
            $VATList[] = $newVAT;
        }

        // article
        $articleList = [];
        for ($i = 0; $i < 100; $i++) {
            $newArticle = new Article();
            $newArticleName = $faker->unique()->word();

            //creation of a random float number between 1 and 5
            $entier = rand(1, 4);
            $decimale = rand(1, 9);
            $nombre = $entier . '.' . $decimale;

            $newArticle->setName($newArticleName)
                ->setDescription($faker->sentence(15))
                ->setPrice(rand(1, 500))
                ->setStock(rand(1, 20))
                ->setRating($nombre)
                ->setPicture('https://picsum.photos/id/' . rand(500, 1000) . '/200/300')
                ->setSlug($newArticleName)
                ->setCreatedAt(new Datetime)
                ->setUpdatedAt(new Datetime)
                ->setDisplayOrder($i<=15?$i:0)
                ->setVat($VATList[rand(1, count($VATList) - 1)])
                ->setBrand($brandList[rand(1, count($brandList) - 1)])
                ->setDiscount($discountList[rand(1, count($discountList) - 1)])
                ->setCategory($categoriesList[rand(1, count($categoriesList) - 1)]);

            $manager->persist($newArticle);
            $articleList[] = $newArticle;
        }

        // favorites

        for ($i = 0; $i < 20; $i++) {
            $newFavorite = new Favorite();

            $newFavorite->setArticle($articleList[rand(1, count($articleList) - 1)])
                ->setUser($i % 2 == 0 ? $newUser : $newUserAdmin);

            $manager->persist($newFavorite);
        };

        // orderlist
        for ($i=0; $i < 100; $i++) { 

            // TODO créer une nouvelle liste de commande
            $newOrderlist = new Orderlist();
            // TODO renseigner toutes les propriétés
            $newOrderlist->setArticle($articleList[rand(0,count($articleList)-1)])
            ->setOrder($orderList[rand(0,count($orderList)-1)])
            ->setQuantity(rand(1,3))
            ->setCreatedAt(new DateTime());
            
            // TODO persist
            $manager->persist($newOrderlist);
        }

        // comment
        for ($i=0; $i < 100; $i++) { 

            // TODO créer un nouveau commentaire
            $newComment = new Comment();
            // TODO renseigner toutes les propriétés

            $newComment->setBody($faker->sentence(15))
                       ->setRating(rand(0,5))
                       ->setArticle($articleList[rand(0,count($articleList)-1)])
                       ->setUser($i%2==0?$newUser:$newUserAdmin)
                       ->setCreatedAt(new DateTime());
         
            // TODO persist
            $manager->persist($newComment);
        }

        $manager->flush();
    }
}
