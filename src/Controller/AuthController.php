<?php

namespace App\Controller;

use App\DTO\User\CreateUserDTO;
use App\DTO\User\LoginUserDTO;
use App\Exception\Request\InvalidRequestException;
use App\Service\AuthService;
use Exception;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use PhpParser\Builder\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;

class AuthController extends AbstractController
{   
    public function __construct(
        private AuthService $authService,
        private ValidatorInterface $validator,
    ) {}

    #[Route('/auth/register', name: 'register_user', methods: [Request::METHOD_POST])]
    public function registerUser(Request $request): JsonResponse
    {   
        try {
            $dto = new CreateUserDTO();

            $createUserDTO = $dto->createFromRequest($request, $this->validator);

            return $this->authService->register($createUserDTO);
        } catch (InvalidRequestException $e) {
            return new JsonResponse(['message' => $e->getMessage(), 'errors' => $e->getErrors()], $e->getCode());
        }

        return new JsonResponse($createUserDTO, 200);
    }

    #[Route('/auth/login', name: 'login_user', methods: [Request::METHOD_POST])]
    public function loginUser(): void
    {}
}