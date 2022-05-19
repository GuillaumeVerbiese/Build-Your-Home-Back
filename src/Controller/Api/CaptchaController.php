<?php

namespace App\Controller\Api;

use App\Service\CaptchaApi;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CaptchaController extends AbstractController
{
    /**
     * @Route("/api/captcha", name="app_api_captcha", methods={"POST"})
     */
    public function index(CaptchaApi $captchaApi, Request $request, SerializerInterface $serializerInterface): JsonResponse
    {

        $jsonContent = $request->getContent();
        
        $json = json_decode($jsonContent);

        $content = $captchaApi->fetch($json['secret'],$json['response']);


        return $this->json(
            $content,

            Response::HTTP_OK,
        );
    }
    
}
