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

    #[Assert\Type('integer')]
    private ?int $userId;

    #[Assert\NotBlank()]
    #[Assert\NotNull()]
    #[Assert\Type('string')]
    private string $targetLocation;

    #[Assert\DateTime]
    private ?string $arrivalDate;

    #[Assert\Type(['integer', 'null'])]
    private ?int $accomodationBudget;

    #[Assert\Type(['integer', 'null'])]
    private ?int $restaurationBudget;

    #[Assert\Type(['integer', 'null'])]
    private ?int $eventsBudget;

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

    public function getAccomodationBudget(): ?int 
    {
        return $this->accomodationBudget;
    }

    public function setAccomodationBudget(?int $accomodationBudget): self 
    {
        $this->accomodationBudget = $accomodationBudget;

        return $this;
    }

    public function getRestaurationBudget(): ?int 
    {
        return $this->restaurationBudget;
    }

    public function setRestaurationBudget(?int $restaurationBudget): self 
    {
        $this->restaurationBudget = $restaurationBudget;

        return $this;
    }

    public function getEventsBudget(): ?int 
    {
        return $this->eventsBudget;
    }

    public function setEventsBudget(?int $eventsBudget): self 
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

    private function getUserIdFromJsonBody(array $jsonContent): int
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

    private function getAccomodationBudgetFromJsonBody(array $jsonContent): ?int
    {
        return $jsonContent['accomodationBudget'] ?? null;
    }

    private function getRestaurationBudgetFromJsonBody(array $jsonContent): int
    {
        return $jsonContent['restaurationBudget'] ?? null;
    }

    private function getEventsBudgetFromJsonBody(array $jsonContent): int
    {
        return $jsonContent['eventsBudget'] ?? null;
    }

    private function hydrate(array $jsonContent): self
    {
        $this
            ->setUserId($this->getUserIdFromJsonBody($jsonContent))
            ->setTargetLocation($this->getTargetLocationFromJsonBody($jsonContent))
            ->setArrivalDate($this->getArrivalDateFromJsonBody($jsonContent))
            ->setAccomodationBudget($this->getAccomodationBudgetFromJsonBody($jsonContent))
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