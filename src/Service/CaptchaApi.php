<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class CaptchaApi
{
    // j'ai tout copié d'ici : 
    // https://symfony.com/doc/current/http_client.html#basic-usage
    private $client;
    private $params;
    /**
     * J'ai besoin de HTTPClient, j'utilise ton l'injection au constructeur
     * Comme ça dès que je demande cette classe, l'injection de HTTPClient seras faites en auto
     *
     * @param HttpClientInterface $client
     * @param ParameterBagInterface $params Nous permet de récupèrer la valeurs dans le fichier services.yaml
     */ 
    public function __construct(HttpClientInterface $client, ParameterBagInterface $params)
    {
        $this->client = $client;
        $this->params = $params;
    }

    public function fetch($secret, $captchaToken)
    {
        $response = $this->client->request(
            'POST',
            'https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secret,
                'response' => $captchaToken
                ],
            
        );

        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        $content = $response->getContent();
       

        return $content;
            
    }

   
}