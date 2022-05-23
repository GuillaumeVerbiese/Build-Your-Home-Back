<?php

namespace App\Tests\Back;

use App\Repository\UserRepository;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DisplayOrderTest extends WebTestCase
{
     public function testDisplayArticleOrder(): void
     {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail('admin@admin.com');

        $client->loginUser($testUser);
        
        $client->request('POST', '/back/order/article/test', [
            '1' => 'dolorum',
            '2' => 'accusamus',
            '3' => 'dolores',
            '4' => 'quisquam',
            '5' => 'quia',
            '6' => 'necessitatibus',
            '7' => 'alias',
            '8' => 'aliquam',
            '9' => 'vel',
            '10' => 'ipsa',
        ]);

        

        $articleRepository = static::getContainer()->get(ArticleRepository::class);
        $testArticle = $articleRepository->findOneByName('accusamus');

        $reponse = $client->getResponse();

        $this->assertEquals(2,$testArticle->getDisplayOrder());
       $this->assertEquals(200,$reponse->getStatusCode());
    }
    public function testRouteDisplayArticleOrder(): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail('admin@admin.com');

        $client->loginUser($testUser);
        
        $crawler = $client->request('GET', '/back/order/article/test');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }


    
    public function testDisplayCategoryOrder(): void
     {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail('admin@admin.com');

        $client->loginUser($testUser);
        
        $client->request('POST', '/back/display/order/category', [
            '1' => 'rétro',
            '2' => 'chaise',
            '3' => 'confort',
            '4' => 'original',
            '5' => 'énergie',
            '6' => 'santé',
            '7' => 'jardin',
            '8' => 'informatique',
            '9' => 'cuisine',
            '10' => 'gaming',
        ]);

        

        $categoryRepository = static::getContainer()->get(CategoryRepository::class);
        $testArticle = $categoryRepository->findOneByName('rétro');

        $reponse = $client->getResponse();

        $this->assertEquals(1,$testArticle->getDisplayOrder());
       $this->assertEquals(200,$reponse->getStatusCode());
    }
    public function testRouteDisplayCategoryOrder(): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail('admin@admin.com');

        $client->loginUser($testUser);
        
        $crawler = $client->request('GET', '/back/display/order/category');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
