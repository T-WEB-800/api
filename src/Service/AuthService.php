<?php

namespace App\Service;

use App\DTO\Auth\AuthRegisterDTO;
use Symfony\Component\HttpFoundation\Response;
use App\DTO\User\CreateUserDTO;
use App\DTO\User\LoginUserDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\DBAL\Exception\ConstraintViolationException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\ConstraintViolation;

class AuthService {
    public function __construct(
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $passwordHasher,
        private EntityManagerInterface $em,
        private JWTTokenManagerInterface $jwtManager,
    ) {}

    public function register(AuthRegisterDTO $dto): JsonResponse
    {
        try {
            $user = new User();
            
            $user->setFirstName($dto->getFirstName())
                    ->setLastName($dto->getLastName())
                    ->setEmail($dto->getEmail())
                    ->setLogin($dto->getLogin())
            ;

            $withHashedPass = $this->hashPass($user, $dto->getPassword());
            
            $this->em->persist($withHashedPass);
            $this->em->flush();

            return new JsonResponse($this->serializeUser($user), Response::HTTP_CREATED);
        } catch (ConstraintViolationException $ex) {
            return new JsonResponse(null, Response::HTTP_BAD_REQUEST);
        } catch (Exception $ex) {
            return new JsonResponse(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function hashPass(User $user, string $plain): User
    {
        $hashedPass = $this->passwordHasher->hashPassword(
            $user,
            $plain
        );

        return $user->setPassword($hashedPass);
    }

    private function serializeUser(User $user): array
    {
        return [
            'user' => [
                'firstName' => $user->getFirstName(),
                'lastName' => $user->getLastName(),
                'email' => $user->getEmail(),
                'login' => $user->getLogin(),
            ],
        ];
    }
}