<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatusController
{
    #[Route('/status', name: 'status', methods: [Request::METHOD_GET])]
    public function status(): Response
    {
        return new JsonResponse(null, Response::HTTP_OK);
    }
}