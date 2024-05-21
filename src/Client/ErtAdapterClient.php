<?php

namespace App\Client;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ErtAdapterClient
{   
    private const ERT_ADAPTER_ACCOMMODATIONS_ENDPOINT = '/google/accommodations';

    public function __construct(
        private HttpClientInterface $ertAdapterClient,
    ) {}

    public function requestAccomodations() 
    {
        try {
            $response = $this->ertAdapterClient->request(
                Request::METHOD_GET,
                self::ERT_ADAPTER_ACCOMMODATIONS_ENDPOINT
            );

            return new JsonResponse($response->getContent(), $response->getStatusCode());
        } catch (Exception $ex) {
            var_dump($ex->getMessage());
        }
    }
}