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
use Symfony\Component\Validator\Constraints\Length;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // TODO récupérer faker
        $faker = Factory::create('fr-FR');

        // user
        // TODO créer un nouvel utilisateur user
        $newUser = new User();
        // TODO renseigner toutes les propriétés
        $newUser->setUserLastname($faker->unique()->lastName())
                ->setUserFirstname($faker->firstName())
                ->setUserAdress($faker->address())
                ->setUserBirthdate(new DateTime())
                ->setPassword('user')// TODO hasher le password
                ->setRoles(['ROLE_USER'])
                ->setEmail('user@user.com')
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
                ->setPassword('admin')// TODO hasher le password
                ->setRoles(['ROLE_ADMIN'])
                ->setEmail('admin@admin.com')
                ->setUserPhone($faker->phoneNumber())
                ->setUserCreatedAt(new DateTime());
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

        // delivery fees
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

        // order
        $orderList = [];
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


            $newBrand->setBrandname($brandNameList[$i])
                ->setBrandSlug($brandNameList[$i])
                ->setBrandCreatedAt(new Datetime)
                ->setBrandUpdatedAt(new Datetime);

            $manager->persist($newBrand);
            $brandList[] = $newBrand;
        }

        // discount
        $discountList = [];
        for ($i = 0; $i < 20; $i++) {
            $newDiscount = new Discount();

            $newDiscount->setDiscountName($faker->word())
                ->setDiscountRate($i * 2)
                ->setDiscountCreatedAt(new Datetime)
                ->setDiscountUpdatedAt(new Datetime);

            $manager->persist($newDiscount);
            $discountList[] = $newDiscount;
        }
        
        // vat
        $VATList = [];
        for ($i = 0; $i < 3; $i++) {
            $newVAT = new VAT();

            if ($i == 0) {
                $newVAT->setVATName("taux normal")
                    ->setVATRate(20)
                    ->setVATCreatedAt(new Datetime)
                    ->setVATUpdatedAt(new Datetime);
            }
            if ($i == 1) {
                $newVAT->setVATName("taux intermediaire")
                    ->setVATRate(10)
                    ->setVATCreatedAt(new Datetime)
                    ->setVATUpdatedAt(new Datetime);
            }
            if ($i == 2) {
                $newVAT->setVATName("taux reduit")
                    ->setVATRate(5.5)
                    ->setVATCreatedAt(new Datetime)
                    ->setVATUpdatedAt(new Datetime);
            }
            $manager->persist($newVAT);
            $VATList[] = $newVAT;
        }

        // article
        $articleList = [];
        for ($i = 0; $i < 20; $i++) {
            $newArticle = new Article();
            $newArticleName = $faker->unique()->word();

            //creation of a random float number between 1 and 5
            $entier = rand(1, 4);
            $decimale = rand(1, 9);
            $nombre = $entier . '.' . $decimale;

            $newArticle->setArticleName($newArticleName)
                ->setArticleDescription($faker->sentence(15))
                ->setArticlePrice(rand(1, 500))
                ->setArticleStock(rand(1, 20))
                ->setArticleRating($nombre)
                ->setArticlePictureLink('https://picsum.photos/id/' . rand(500, 1000) . '/200/300')
                ->setArticleSlug($newArticleName)
                ->setArticleCreatedAt(new Datetime)
                ->setArticleUpdatedAt(new Datetime)
                ->setArticleVat($VATList[rand(1, count($VATList) - 1)])
                ->setArticleBrand($brandList[rand(1, count($brandList) - 1)])
                ->setArticleDiscount($discountList[rand(1, count($discountList) - 1)])
                ->setArticleCategory($categoriesList[rand(1, count($categoriesList) - 1)]);

            $manager->persist($newArticle);
            $articleList[] = $newArticle;
        }

        // favorites

        for ($i = 0; $i < 20; $i++) {
            $newFavorite = new Favorite();

            $newFavorite->setFavoriteArticle($articleList[rand(1, count($articleList) - 1)])
                ->setFavoriteUser($i % 2 == 0 ? $newUser : $newUserAdmin);

            $manager->persist($newFavorite);
        };

        // orderlist
        for ($i=0; $i < 100; $i++) { 

            // TODO créer une nouvelle liste de commande
            $newOrderlist = new Orderlist();
            // TODO renseigner toutes les propriétés
            $newOrderlist->setOrderlistArticle($articleList[rand(0,count($articleList)-1)])
            ->setOrderlistOrder($orderList[rand(0,count($orderList)-1)])
            ->setOrderlistQuantity(rand(1,3))
            ->setOrderlistCreatedAt(new DateTime());
            
            // TODO persist
            $manager->persist($newOrderlist);
        }

        // comment
        for ($i=0; $i < 100; $i++) { 

            // TODO créer un nouveau commentaire
            $newComment = new Comment();
            // TODO renseigner toutes les propriétés

            $newComment->setCommentBody($faker->sentence(15))
                       ->setCommentRating(rand(0,5))
                       ->setCommentArticle($articleList[rand(0,count($articleList)-1)])
                       ->setCommentUser($i%2==0?$newUser:$newUserAdmin)
                       ->setCommentCreatedAt(new DateTime());
         
            // TODO persist
            $manager->persist($newComment);
        }

        $manager->flush();
    }
}
