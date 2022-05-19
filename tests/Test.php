<?php

namespace App\Tests;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class Test extends WebTestCase
{
        /**
     * Tester les route interdite à un user
     * 
     * avec l'annotation dataProvider et un nom de function
     * cela permet de remplir la valeur de $url automatiquement 
     * suivant les valeurs retournés par cette function
     * 
     * 
     */
    public function testArticle(): void
    {
        
            // je créer mon client HTTP
        $client = static::createClient();
            
        // TODO : on récupère la route
        $crawler = $client->request('POST', '/' );
    
        // TODO : on teste que la réponse de redirection vers la page de login
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    
}

}
