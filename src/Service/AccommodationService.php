<?php

namespace App\Service;

use App\Client\AdapterClient;
use App\Client\ErtAdapterClient;
use App\DTO\Accomodation\AccomodationRequestDTO;
use Symfony\Component\HttpFoundation\JsonResponse;

class AccommodationService
{
    public function __construct(
        private ErtAdapterClient $ertAdapterClient,
    ) {}

    // public function getLocationAccommodations(AccomodationRequestDTO $dto): JsonResponse
    // {
    //     try {
    //         $response = $this->ertAdapterClient->requestAccomodations();
    //     }
    // }
}