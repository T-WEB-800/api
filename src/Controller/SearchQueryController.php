<?php

namespace App\Controller;

use App\Entity\User;
use App\DTO\SearchQuery\CreateSearchQueryDTO;
use App\Exception\Request\ForbiddenRequestException;
use App\Exception\Request\InvalidRequestException;
use App\Guard\UserResourceGuard;
use App\Service\SearchQueryService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SearchQueryController extends AbstractController
{   
    public function __construct(
        private SearchQueryService $searchQueryService,
        private ValidatorInterface $validator,
    ) {}

    #[Route(path: '/searches', name: 'create_search_query', methods: [Request::METHOD_POST])]
    public function createSearchQuery(Request $request): JsonResponse
    {   
        try {
            $dto = new CreateSearchQueryDTO();

            $createSearchDTO = $dto->createFromRequest($request, $this->validator);

            return $this->searchQueryService->create($createSearchDTO);
        } catch (InvalidRequestException $e) {
            return new JsonResponse(['message' => $e->getMessage(), 'errors' => $e->getErrors()], $e->getCode());
        }
    }

    #[Route(path: '/searches/user/{userId}', name: 'delete_user_search_queries', methods: [Request::METHOD_DELETE])]
    public function deleteUserSearchQueries(int $userId): JsonResponse
    {   
        try {
            UserResourceGuard::RequestUserResourceAccess($this->getUser(), $userId);

            return $this->searchQueryService->deleteSearchQueriesForUser($userId);
        } catch (ForbiddenRequestException $ex) {
            return new JsonResponse(null, Response::HTTP_FORBIDDEN);
        }
    }

    #[Route(path: '/searches/user/{userId}/{searchQueryId}', name: 'delete_search_query', methods: [Request::METHOD_DELETE])]
    public function deleteSearchQuery(int $userId, int $searchQueryId): JsonResponse
    {   
        try {
            UserResourceGuard::RequestUserResourceAccess($this->getUser(), $userId);

            return $this->searchQueryService->delete($searchQueryId);
        } catch (ForbiddenRequestException $ex) {
            return new JsonResponse(null, Response::HTTP_FORBIDDEN);
        }
    }

    #[Route(path: '/searches/user/{userId}', name: 'get_user_search_queries', methods: [Request::METHOD_GET])]
    public function getUserSearchQueries(int $userId): JsonResponse
    {
        try {
            UserResourceGuard::RequestUserResourceAccess($this->getUser(), $userId);

            return $this->searchQueryService->getSearchQueriesForUser($userId);
        } catch (ForbiddenRequestException $ex) {
            return new JsonResponse(null, Response::HTTP_FORBIDDEN);
        }
    }
}