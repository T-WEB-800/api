<?php

namespace App\Service;

use App\DTO\SearchQuery\CreateSearchQueryDTO;
use App\Entity\User;
use App\Entity\SearchQuery;
use App\Repository\SearchQueryRepository;
use App\Repository\UserRepository;
use Carbon\Carbon;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Exception\ConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SearchQueryService {
    public function __construct(
        private UserRepository $userRepository,
        private SearchQueryRepository $searchQueryRepository,
        private EntityManagerInterface $em,
    ) {}

    public function create(CreateSearchQueryDTO $dto): JsonResponse
    {   
        try {
                    
            /**
            * @var User $user
            */
            $user = $this->userRepository->find($dto->getUserId());
            
            $searchQuery = new SearchQuery();
    
            $searchQuery->setDepartureLocation($dto->getDepartureLocation())
                    ->setDepartureDate($this->getDateTimeFromString($dto->getDepartureDate()))
                    ->setArrivalLocation($dto->getArrivalLocation())
                    ->setArrivalDate($this->getDateTimeFromString($dto->getArrivalDate()))
                    ->setPreferredTransportation($dto->getPreferredTransportation())
            ;
            
            $user->addSearchQuery($searchQuery);

            $this->em->persist($searchQuery);
            $this->em->flush();

            return new JsonResponse($searchQuery, Response::HTTP_CREATED);
        } catch (ConstraintViolationException $ex) {
            return new JsonResponse(null, Response::HTTP_BAD_REQUEST);
        } catch (Exception $ex) {
            return new JsonResponse(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete(int $searchQueryId)
    {
        try {
            $searchQuery = $this->searchQueryRepository->find($searchQueryId);
            
            if (!$searchQuery) {
                return new JsonResponse(null, Response::HTTP_NOT_FOUND);
            }

            $this->em->remove($searchQuery);
            $this->em->flush();

            return new JsonResponse(null, Response::HTTP_OK);
        } catch (Exception $ex) {
            return new JsonResponse(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getSearchQueriesForUser(int $userId): JsonResponse
    {
        try {
            /**
             * @var User $user
             */
            $user = $this->userRepository->find($userId);

            $result = [];
            
            $searchQueries = $user->getSearchQueries();

            if ($searchQueries->count() === 0) {
                return new JsonResponse(null, Response::HTTP_NOT_FOUND);
            }

            foreach ($searchQueries as $searchQuery) {
                $result[] = $this->serializeSearchQuery($searchQuery);
            }

            return new JsonResponse($result, Response::HTTP_OK);
        } catch (Exception $ex) {
            return new JsonResponse(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteSearchQueriesForUser(int $userId): JsonResponse
    {
        try {
            /**
             * @var User $user
             */
            $user = $this->userRepository->find($userId);

            $searchQueries = $user->getSearchQueries();

            if ($searchQueries->count() === 0) {
                return new JsonResponse(null, Response::HTTP_NOT_FOUND);
            }

            foreach ($searchQueries as $searchQuery) {
                $this->em->remove($searchQuery);
            }

            $this->em->flush();

            return new JsonResponse(null, Response::HTTP_OK);
        } catch (Exception $ex) {
            return new JsonResponse(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function getDateTimeFromString(string $date): Carbon
    {
        $toObject = Carbon::createFromFormat('Y-m-d H:i:s', $date);

        return $toObject;
    }

    private function serializeSearchQuery(SearchQuery $searchQuery): array 
    {
        return [
            'departureLocation' => $searchQuery->getDepartureLocation(),
            'departureDate' => $searchQuery->getDepartureDate(),
            'arrivalLocation' => $searchQuery->getArrivalLocation(),
            'arrivalDate' => $searchQuery->getArrivalDate(),
            'preferredTransportation' => $searchQuery->getPreferredTransportation()
        ];
    }
}