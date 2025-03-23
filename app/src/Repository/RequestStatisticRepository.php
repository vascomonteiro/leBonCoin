<?php

namespace App\Repository;

use App\Entity\RequestStatistic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class RequestStatisticRepository extends ServiceEntityRepository
{
    /**
     * RequestStatisticRepository constructor.
     *
     * Initializes the repository with the entity manager registry and the RequestStatistic entity.
     * This allows interaction with the database for the RequestStatistic entity.
     *
     * @param ManagerRegistry $registry The manager registry for accessing the Doctrine ORM.
     */
    public function __construct(ManagerRegistry $registry)
    {
        // Call the parent constructor to initialize the repository with the provided registry and entity class
        parent::__construct($registry, RequestStatistic::class);
    }

    /**
     * Fetches the most frequent request based on the 'count' field.
     *
     * This method retrieves the RequestStatistic entity with the highest count. 
     * It orders the results by the count field in descending order, ensuring that 
     * the most frequent request is fetched first. Only one result is returned.
     *
     * @return RequestStatistic|null The most frequent RequestStatistic or null if no results are found.
     */
    public function findMostFrequentRequest()
    {
        // Build a query to get the most frequent request by ordering by count descending
        return $this->createQueryBuilder('r')
            ->orderBy('r.count', 'DESC') // Sort by count in descending order
            ->setMaxResults(1) // Limit the result to one record (most frequent)
            ->getQuery() // Get the query object
            ->getOneOrNullResult(); // Execute the query and return either one result or null if not found
    }
}
