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
        
        $json = json_decode($jsonContent, true);

         $content = $captchaApi->fetch($json['secret'],$json['response']);
       // $content = $captchaApi->fetch('','03AGdBq27FBpfZhpd8K5D48xljR8HbneSbgqDHeQqMFyE55eDxtP3ZLqZnCMKpO82C2u7gZm0dHNDCyAgYRm32UJCQ2Ef32d46MAb0eyutSZY1rbQst9dcEOIt5wuCFtYAl2O5EV95o8kK2auTvzUMQAYlg8qi4Oy-Shh5rUi9wi-FQuAXTP9fhKrEWuykpz-Ea0nX3pX9WEeIyCqEYxN4VjF1LZvaQr-bOzuYjWVAAlXVP_vQncXL85GznJN7f2m3gXVaCbhwUZ0g7Xuj7CAJpvjwgD78GtRmcgoDJZM6UmgAgDryDuM8HU6RkwxT7kqcZhnNmAHInAaM_8xfqW21HoOffdme4cGRSOkdEWyaPRrOVgMt8nuFnOVvlKnXtMqJ58CAsjYkhrkjvqNEpuWyAFxMazAHQaR2JCNtlgtfiCn-S5ll7n3vRiHkqT7cOmTPfEx6T-dZUVV_A71zaTMBJGafXrUkaINDsg');

         return $this->json(
             $content,

             Response::HTTP_OK,
         );
    }
    
}
