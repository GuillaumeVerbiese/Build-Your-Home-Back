<?php

namespace App\DataFixtures;

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

        // TODO boucler pour en créer 20
        for ($i = 0; $i < 20; $i++) {

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

        //brand
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

        //discount
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
        $manager->flush();

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



        $categoriesList = [];
        $categoryNameList = ["electroménager", "image", "son", "téléphone", "console", "gaming", "cuisine", "informatique", "tablette", "jardin", "beauté", "santé"];
        for ($i = 1; $i < 10; $i++) {

            // TODO créer une nouvelle categorie
            $newCategory = new Category();
            // TODO renseigner toutes les propriétés
            $name = $categoryNameList[$i];
            $newCategory->setCategoryName($name)
                ->setCategoryPictureLink('https://picsum.photos/id/' . rand(500, 1000) . '/200/300')
                ->setCategorySlug($name)
                ->setCategoryDisplayOrder($i <= 5 ? $i : 0)
                ->setCategoryCreatedAt(new DateTime());
            // TODO persist
            $manager->persist($newCategory);
            // TODO l'ajouter à la liste
            $categoriesList[] = $newCategory;
        };




        $articleList = [];
        for ($i = 0; $i < 20; $i++) {
            $newArticle = new Article();
            $newArticleName = $faker->unique()->word();

            //creation of a random float number between 1 and 5
            $entier = rand(1, 4);
            $decimale = rand(1, 9);
            $nombre = $entier . '.' . $decimale;

            $newArticle->setArticleName($newArticleName)
                ->setArticleDescription($faker->paragraph())
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

        // Fixture des Favorites

        for ($i = 0; $i < 20; $i++) {
            $newFavorite = new Favorite();

            $newFavorite->setFavoriteArticle($articleList[rand(1, count($articleList) - 1)])
                ->setFavoriteUser($i % 2 == 0 ? $newUser : $newUserAdmin);

            $manager->persist($newFavorite);
        };

        $manager->flush();
    }
}
