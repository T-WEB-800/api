<?php 

namespace App\DTO\Auth;

use App\DTO\Interface\RequestDTOInterface;
use App\Exception\Request\InvalidRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AuthRegisterDTO implements RequestDTOInterface {

    public function __construct() {}

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Length(min: 2)]
    #[Assert\Regex(
        pattern: "/[a-zA-Z']+$/",
        message: 'First Name must be composed of alphabetical characters only'
    )]
    private ?string $firstName;
    
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Length(min: 2)]
    #[Assert\Regex(
        pattern: "/[a-zA-Z']+$/",
        message: 'Last Name must be composed of alphabetical characters only'
    )]
    private ?string $lastName;

    #[Assert\NotBlank]
    #[Assert\Email(
        message: 'Email must be a valid email address'
    )]
    private ?string $email;
    
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    private ?string $login;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Length(min: 8)]
    #[Assert\Regex(
        pattern: '/\d+/i',
        message: "Password must contain a number"
    )]
    #[Assert\Regex(
        pattern: '/[A-Z]/',
        message: "Password must contain at least one uppercased character"
    )]
    #[Assert\Regex(
        pattern: '/[#?!@$%^&*-]+/i',
        message: 'Password must contain at least one special character'
    )]
    private ?string $password;
    
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName) 
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email) 
    {
        $this->email = $email;

        return $this;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login) 
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password) 
    {
        $this->password = $password;

        return $this;
    }

    public function createFromRequest(Request $request, ValidatorInterface $validator): AuthRegisterDTO
    {
        $requestBody = json_decode($request->getContent(), true);

        $dto = $this->hydrate($requestBody);

        $dto->validate($validator);

        return $dto;
    }

    private function getFirstNameFromJsonBody(array $jsonContent): ?string
    {
        return $jsonContent['firstName'] ?? null;
    }

    private function getLastNameFromJsonBody(array $jsonContent): ?string
    {
        return $jsonContent['lastName'] ?? null;
    }

    private function getEmailFromJsonBody(array $jsonContent): ?string
    {
        return $jsonContent['email'] ?? null;
    }

    private function getLoginFromJsonBody(array $jsonContent): ?string
    {
        return $jsonContent['login'] ?? null;
    }

    private function getPasswordFromJsonBody(array $jsonContent): ?string
    {
        return $jsonContent['password'] ?? null;
    }

    private function hydrate(array $jsonContent): self
    {
        $this
            ->setFirstName($this->getFirstNameFromJsonBody($jsonContent))
            ->setLastName($this->getLastNameFromJsonBody($jsonContent))
            ->setEmail($this->getEmailFromJsonBody($jsonContent))
            ->setLogin($this->getLoginFromJsonBody($jsonContent))
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