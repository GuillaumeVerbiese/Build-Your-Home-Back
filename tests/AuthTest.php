<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AuthTest extends WebTestCase
{
    public function testConnexion(): void
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '/login',['email'=>'admin@admin.com','password'=>'admin']);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }
}
