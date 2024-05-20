<?php

namespace App\Controller;

use App\DTO\Auth\AuthRegisterDTO;
use App\Exception\Request\InvalidRequestException;
use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
            $dto = new AuthRegisterDTO();

            $authRegisterDTO = $dto->createFromRequest($request, $this->validator);

            return $this->authService->register($authRegisterDTO);
        } catch (InvalidRequestException $e) {
            return new JsonResponse(['message' => $e->getMessage(), 'errors' => $e->getErrors()], $e->getCode());
        }

        return new JsonResponse($authRegisterDTO, 200);
    }

    #[Route('/auth/login', name: 'login_user', methods: [Request::METHOD_POST])]
    public function loginUser(): void
    {}
}