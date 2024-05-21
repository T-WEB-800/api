<?php

namespace App\Controller;

use App\Client\ErtAdapterClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccommodationController extends AbstractController
{   
    public function __construct(
        private ErtAdapterClient $ertAdapterClient,
    ) {}
    
    #[Route('/locations/sleep', name: 'get_location_accommodations', methods: [Request::METHOD_POST])]
    public function getLocationAccommodations(): JsonResponse
    {
        return $this->ertAdapterClient->requestAccomodations();
    }
}