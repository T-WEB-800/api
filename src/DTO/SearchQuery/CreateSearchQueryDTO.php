<?php 

namespace App\DTO\SearchQuery;

use App\DTO\Interface\RequestDTOInterface;
use App\Exception\Request\InvalidRequestException;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateSearchQueryDTO implements RequestDTOInterface {

    public function __construct() {}

    #[Assert\NotBlank()]
    #[Assert\NotNull()]
    #[Assert\Type('integer')]
    private int $userId;

    #[Assert\NotBlank()]
    #[Assert\NotNull()]
    #[Assert\Type('string')]
    private string $departureLocation;

    #[Assert\NotBlank()]
    #[Assert\NotNull()]
    #[Assert\DateTime]
    private string $departureDate;

    #[Assert\NotBlank()]
    #[Assert\NotNull()]
    #[Assert\Type('string')]
    private string $arrivalLocation;

    #[Assert\NotBlank()]
    #[Assert\NotNull()]
    #[Assert\DateTime]
    private string $arrivalDate;

    #[Assert\NotBlank()]
    #[Assert\NotNull()]
    #[Assert\Choice(['TRANSPORTATION_CAR', 'TRANSPORTATION_TRAIN', 'TRANSPORTATION_COACH', 'TRANSPORTATION_PLANE'])]
    private string $preferredTransportation;

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getDepartureLocation(): string 
    {
        return $this->departureLocation;
    }

    public function setDepartureLocation(string $departureLocation): self 
    {
        $this->departureLocation = $departureLocation;

        return $this;
    }
    
    public function getDepartureDate(): string 
    {
        return $this->departureDate;
    }

    public function setDepartureDate(string $departureDate): self 
    {
        $this->departureDate = $departureDate;

        return $this;
    }

    public function getArrivalLocation(): string 
    {
        return $this->arrivalLocation;
    }

    public function setArrivalLocation(string $arrivalLocation): self 
    {
        $this->arrivalLocation = $arrivalLocation;

        return $this;
    }

    public function getArrivalDate(): string 
    {
        return $this->arrivalDate;
    }

    public function setArrivalDate(string $arrivalDate): self 
    {
        $this->arrivalDate = $arrivalDate;

        return $this;
    }

    public function getPreferredTransportation(): string
    {
        return $this->preferredTransportation;
    }

    public function setPreferredTransportation(string $preferredTransportation): self
    {
        $this->preferredTransportation = $preferredTransportation;

        return $this;
    }

    public function createFromRequest(Request $request, ValidatorInterface $validator): CreateSearchQueryDTO
    {
        $requestBody = json_decode($request->getContent(), true);

        $dto = $this->hydrate($requestBody);

        $dto->validate($validator);

        return $dto;
    }

    private function getUserIdFromJsonBody(array $jsonContent): int
    {
        return $jsonContent['userId'] ?? null;
    }

    private function getDepartureLocationFromJsonBody(array $jsonContent): ?string
    {
        return $jsonContent['departureLocation'] ?? null;
    }

    private function getDepartureDateFromJsonBody(array $jsonContent): ?string
    {
        return $jsonContent['departureDate'] ?? null;
    }

    private function getArrivalLocationFromJsonBody(array $jsonContent): ?string
    {
        return $jsonContent['arrivalLocation'] ?? null;
    }

    private function getArrivalDateFromJsonBody(array $jsonContent): ?string
    {
        return $jsonContent['arrivalDate'] ?? null;
    }

    private function getPreferredTransportationFromJsonBody(array $jsonContent): ?string
    {
        return $jsonContent['preferredTransportation'] ?? null;
    }

    private function hydrate(array $jsonContent): self
    {
        $this
            ->setUserId($this->getUserIdFromJsonBody($jsonContent))
            ->setDepartureLocation($this->getDepartureLocationFromJsonBody($jsonContent))
            ->setDepartureDate($this->getDepartureDateFromJsonBody($jsonContent))
            ->setArrivalLocation($this->getArrivalLocationFromJsonBody($jsonContent))
            ->setArrivalDate($this->getArrivalDateFromJsonBody($jsonContent))
            ->setPreferredTransportation($this->getPreferredTransportationFromJsonBody($jsonContent))
        ;
        
        return $this;
    }

    private function validate(ValidatorInterface $validator): void
    {   
        $errors = $validator->validate($this);
        $errorMessages = [];

        if (count($errors) > 0) {

            foreach ($errors as $error) {
                $errorMessages[] = $error->getPropertyPath() . ' : ' . $error->getMessage();
            }

            throw new InvalidRequestException($errorMessages);
        }
    }
}