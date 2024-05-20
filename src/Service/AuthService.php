<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use App\DTO\User\CreateUserDTO;
use App\DTO\User\LoginUserDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManager;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthService {
    public function __construct(
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $passwordHasher,
        private EntityManagerInterface $em,
        private JWTTokenManagerInterface $jwtManager,
    ) {}

    public function register(CreateUserDTO $dto): JsonResponse
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
        } catch (UniqueConstraintViolationException $ex) {
            return new JsonResponse(null, Response::HTTP_FORBIDDEN);
        } catch (Exception $ex) {
            return new JsonResponse(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function login(LoginUserDTO $dto): JsonResponse
    {
        try {
            $user = $this->userRepository->findOneBy(['login' => $dto->getUsername()]);

            var_dump($user);
            die();

            if ($user && $user->getPassword() === $dto->getPassword()) {
                $token = $this->jwtManager->create($user);

                return new JsonResponse(['token' => $token], Response::HTTP_OK);
            }

            return new JsonResponse(null, Response::HTTP_UNAUTHORIZED);
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