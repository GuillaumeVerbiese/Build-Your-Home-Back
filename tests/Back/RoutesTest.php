<?php

namespace App\Tests\Back;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RoutesTest extends WebTestCase
{
    
        public function testHome(): void
    {
        
            // je créer mon client HTTP
        $client = static::createClient();
            
        // TODO : on récupère la route
        $crawler = $client->request('GET', '/' );
    
        
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    

    }
    public function testLoginBack(): void
    {
        
            // je créer mon client HTTP
        $client = static::createClient();
            
        // TODO : on récupère la route
        $crawler = $client->request('GET', '/login' );
    
        
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    

    }
    public function testArticleBack(): void
    {
        
            // je créer mon client HTTP
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin@admin.com');

        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/back/article/' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    
        $crawler = $client->request('GET', '/back/article/new' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $crawler = $client->request('POST', '/back/article/new' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $crawler = $client->request('GET', '/back/article/1' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $crawler = $client->request('GET', '/back/article/1/edit' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $crawler = $client->request('POST', '/back/article/1/edit' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        


    }
    public function testBrandBack(): void
    {
        
            // je créer mon client HTTP
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin@admin.com');

        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/back/brand/' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    
        $crawler = $client->request('GET', '/back/brand/new' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $crawler = $client->request('POST', '/back/brand/new' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $crawler = $client->request('GET', '/back/brand/1' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $crawler = $client->request('GET', '/back/brand/1/edit' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $crawler = $client->request('POST', '/back/brand/1/edit' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        
    }
    public function testDiscountBack(): void
    {
        
            // je créer mon client HTTP
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin@admin.com');

        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/back/discount/' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    
        $crawler = $client->request('GET', '/back/discount/new' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $crawler = $client->request('POST', '/back/discount/new' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $crawler = $client->request('GET', '/back/discount/1' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $crawler = $client->request('GET', '/back/discount/1/edit' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $crawler = $client->request('POST', '/back/discount/1/edit' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);        
    }
    public function testOrderBack(): void
    {
        
            // je créer mon client HTTP
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin@admin.com');

        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/back/order/' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $crawler = $client->request('GET', '/back/order/1' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $crawler = $client->request('GET', '/back/order/1/edit' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $crawler = $client->request('POST', '/back/order/1/edit' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);        
    }
    public function testCategoryBack(): void
    {
        
            // je créer mon client HTTP
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin@admin.com');

        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/back/category/' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    
        $crawler = $client->request('GET', '/back/category/new' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $crawler = $client->request('POST', '/back/category/new' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $crawler = $client->request('GET', '/back/category/1' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $crawler = $client->request('GET', '/back/category/1/edit' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $crawler = $client->request('POST', '/back/category/1/edit' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);        
    }
    public function testVatBack(): void
    {
        
            // je créer mon client HTTP
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin@admin.com');

        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/back/vat/' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    
        $crawler = $client->request('GET', '/back/vat/new' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $crawler = $client->request('POST', '/back/vat/new' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $crawler = $client->request('GET', '/back/vat/1' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $crawler = $client->request('GET', '/back/vat/1/edit' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $crawler = $client->request('POST', '/back/vat/1/edit' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);        
    }
    public function testDeliveriesfeesBack(): void
    {
        
            // je créer mon client HTTP
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin@admin.com');

        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/back/deliveriesfees/' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    
        $crawler = $client->request('GET', '/back/deliveriesfees/new' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $crawler = $client->request('POST', '/back/deliveriesfees/new' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $crawler = $client->request('GET', '/back/deliveriesfees/1' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $crawler = $client->request('GET', '/back/deliveriesfees/1/edit' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $crawler = $client->request('POST', '/back/deliveriesfees/1/edit' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);        
    }
    public function testUserBack(): void
    {
        
            // je créer mon client HTTP
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin@admin.com');

        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/back/user/' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    
        $crawler = $client->request('GET', '/back/user/new' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $crawler = $client->request('POST', '/back/user/new' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $crawler = $client->request('GET', '/back/user/1' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $crawler = $client->request('GET', '/back/user/1/edit' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $crawler = $client->request('POST', '/back/user/1/edit' );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);        
    }
    
}
