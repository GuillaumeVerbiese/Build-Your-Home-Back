<?php

namespace App\Tests\Api;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserTest extends WebTestCase
{
    public function testWithoutConnectedUser(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/user/profile');

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        
        $crawler = $client->jsonRequest('POST', '/api/user/add', [
            "lastname"  => "string",
            "firstname" => "string",
            "adress"    => "string",
            "birthdate" => "2022-05-18",
            "email"     => "test@test.com",
            "password"  => "string",
            "phone"     => "string"
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);


        $crawler = $client->jsonRequest('POST', '/api/user/add', [
            "lastname"  => "string"
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);

    }

    public function testReadUserLogged()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail('test@test.com');

        $client->loginUser($testUser);

        $client->request('GET', '/api/user/profile');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
                
    }

    public function testModifyUserLogged200()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('test@test.com');
        $client->loginUser($testUser);

        $client->jsonRequest('PATCH', '/api/user/'.$testUser->getId(), [
            "lastname"  => "test",
            "firstname" => "string",
            "adress"    => "string",
            "birthdate" => "2022-05-18",
            "email"     => "test@test.com",
            "password"  => "string",
            "phone"     => "string"
        ]);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
                
    }

    public function testModifyUserLogged403()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('test@test.com');
        $client->loginUser($testUser);

        $client->jsonRequest('PATCH', '/api/user/2', [
            "lastname"  => "test"
        ]);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
                
    }

    public function testModifyUserLogged400()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('test@test.com');
        $client->loginUser($testUser);

        $client->jsonRequest('PATCH', '/api/user/'.$testUser->getId(), [
            "lastname"  => ""
        ]);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
                
    }

    public function testGetJWToken()
    {
        $client = static::createClient();
        $client->jsonRequest('POST', '/api/login_check', [
            "username" => "test@test.com",
            "password" => "string"
        ]);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $response = $client->getResponse()->getContent();
        // var_dump($response);
        $this->assertStringContainsString('token',$response);

    }

    public function testDeleteUserLogged404()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('test@test.com');
        $client->loginUser($testUser);

        $client->request('DELETE', '/api/user/5');
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    public function testDeleteUserLogged403()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('test@test.com');
        $client->loginUser($testUser);

        $client->request('DELETE', '/api/user/2');
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testDeleteUserLogged200()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('test@test.com');
        $client->loginUser($testUser);

        $client->request('DELETE', '/api/user/'.$testUser->getId());
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    
}
