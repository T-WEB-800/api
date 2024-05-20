<?php 

namespace App\DTO\Auth;

use App\DTO\Interface\RequestDTOInterface;
use App\Exception\Request\InvalidRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AuthLoginDTO implements RequestDTOInterface {

    public function __construct() {}

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    private ?string $username;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    private ?string $password;

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    } 

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function createFromRequest(Request $request, ValidatorInterface $validator): AuthLoginDTO
    {
        $requestBody = json_decode($request->getContent(), true);

        $dto = $this->hydrate($requestBody);

        $dto->validate($validator);

        return $dto;
    }

    private function getUserNameFromJsonBody(array $jsonContent): ?string
    {
        return $jsonContent['username'] ?? null;
    }

    private function getPasswordFromJsonBody(array $jsonContent): ?string
    {
        return $jsonContent['password'] ?? null;
    }

    private function hydrate(array $jsonContent): self
    {
        $this
            ->setUsername($this->getUserNameFromJsonBody($jsonContent))
            ->setPassword($this->getPasswordFromJsonBody($jsonContent))
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