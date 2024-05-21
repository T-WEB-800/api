<?php 

namespace App\DTO\SearchQuery;

use App\DTO\Interface\RequestDTOInterface;
use App\Exception\Request\InvalidRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateSearchQueryDTO implements RequestDTOInterface {

    public function __construct() {}

    #[Assert\Type('integer')]
    private ?int $userId;

    #[Assert\NotBlank()]
    #[Assert\NotNull()]
    #[Assert\Type('string')]
    private string $targetLocation;

    #[Assert\DateTime]
    private ?string $arrivalDate;

    #[Assert\Choice(['PRICE_LEVEL_INEXPENSIVE', 'PRICE_LEVEL_MODERATE', 'PRICE_LEVEL_EXPENSIVE', 'PRICE_LEVEL_VERY_EXPENSIVE', null])]
    private ?string $accommodationBudget;

    #[Assert\Choice(['PRICE_LEVEL_INEXPENSIVE', 'PRICE_LEVEL_MODERATE', 'PRICE_LEVEL_EXPENSIVE', 'PRICE_LEVEL_VERY_EXPENSIVE', null])]
    private ?string $restaurationBudget;

    #[Assert\Choice(['PRICE_LEVEL_INEXPENSIVE', 'PRICE_LEVEL_MODERATE', 'PRICE_LEVEL_EXPENSIVE', 'PRICE_LEVEL_VERY_EXPENSIVE', null])]
    private ?string $eventsBudget;

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getTargetLocation(): string 
    {
        return $this->targetLocation;
    }

    public function setTargetLocation(string $targetLocation): self 
    {
        $this->targetLocation = $targetLocation;

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

    public function getAccommodationBudget(): ?string 
    {
        return $this->accommodationBudget;
    }

    public function setAccommodationBudget(?string $accommodationBudget): self 
    {
        $this->accommodationBudget = $accommodationBudget;

        return $this;
    }

    public function getRestaurationBudget(): ?string 
    {
        return $this->restaurationBudget;
    }

    public function setRestaurationBudget(?string $restaurationBudget): self 
    {
        $this->restaurationBudget = $restaurationBudget;

        return $this;
    }

    public function getEventsBudget(): ?string 
    {
        return $this->eventsBudget;
    }

    public function setEventsBudget(?string $eventsBudget): self 
    {
        $this->eventsBudget = $eventsBudget;

        return $this;
    }

    public function createFromRequest(Request $request, ValidatorInterface $validator): CreateSearchQueryDTO
    {
        $requestBody = json_decode($request->getContent(), true);

        $dto = $this->hydrate($requestBody);

        $dto->validate($validator);

        return $dto;
    }

    private function getUserIdFromJsonBody(array $jsonContent): ?int
    {
        return $jsonContent['userId'] ?? null;
    }

    private function getTargetLocationFromJsonBody(array $jsonContent): string
    {
        return $jsonContent['targetLocation'] ?? null;
    }

    private function getArrivalDateFromJsonBody(array $jsonContent): ?string
    {
        return $jsonContent['arrivalDate'] ?? null;
    }

    private function getAccommodationBudgetFromJsonBody(array $jsonContent): ?string
    {
        return $jsonContent['accommodationBudget'] ?? null;
    }

    private function getRestaurationBudgetFromJsonBody(array $jsonContent): ?string
    {
        return $jsonContent['restaurationBudget'] ?? null;
    }

    private function getEventsBudgetFromJsonBody(array $jsonContent): ?string
    {
        return $jsonContent['eventsBudget'] ?? null;
    }

    private function hydrate(array $jsonContent): self
    {
        $this
            ->setUserId($this->getUserIdFromJsonBody($jsonContent))
            ->setTargetLocation($this->getTargetLocationFromJsonBody($jsonContent))
            ->setArrivalDate($this->getArrivalDateFromJsonBody($jsonContent))
            ->setAccommodationBudget($this->getAccommodationBudgetFromJsonBody($jsonContent))
            ->setRestaurationBudget($this->getRestaurationBudgetFromJsonBody($jsonContent))
            ->setEventsBudget($this->getEventsBudgetFromJsonBody($jsonContent))
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