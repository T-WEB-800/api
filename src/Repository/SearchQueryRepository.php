<?php

namespace App\Repository;

use App\Entity\SearchQuery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SearchQuery>
 *
 * @method SearchQuery|null find($id, $lockMode = null, $lockVersion = null)
 * @method SearchQuery|null findOneBy(array $criteria, array $orderBy = null)
 * @method SearchQuery[]    findAll()
 * @method SearchQuery[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SearchQueryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SearchQuery::class);
    }
}
