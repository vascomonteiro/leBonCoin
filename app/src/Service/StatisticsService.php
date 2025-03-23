<?php
// src/Service/StatisticsService.php

namespace App\Service;

use App\Entity\RequestStatistic;
use Doctrine\ORM\EntityManagerInterface;

class StatisticsService
{
    private $entityManager;

    /**
     * StatisticsService constructor.
     *
     * Initializes the service with the entity manager to interact with the database.
     * 
     * @param EntityManagerInterface $entityManager The entity manager used to persist and retrieve entities.
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Increments the request count for a given set of parameters.
     *
     * This method checks if the provided parameters already exist in the database. If they do, 
     * it increments the count of the corresponding RequestStatistic entity. 
     * If no matching entity is found, a new RequestStatistic entity is created with a count of 1.
     *
     * @param array $parameters The parameters representing the FizzBuzz request.
     */
    public function incrementRequestCount(array $parameters): void
    {
        // Create a query to search for existing statistics with the given parameters
        $query = $this->entityManager->createQueryBuilder()
            ->select('r')
            ->from(RequestStatistic::class, 'r')
            ->where('r.params = :params')
            ->setParameter('params', json_encode($parameters)) // Parameters are stored as JSON in the database
            ->getQuery();

        // Fetch the result (first entry or null if no match is found)
        $statistics = $query->getResult()[0] ?? null;

        if ($statistics) {
            // If statistics exist, increment the count
            $statistics->setCount($statistics->getCount() + 1);
        } else {
            // If no statistics exist, create a new entry with count set to 1
            $statistics = new RequestStatistic();
            $statistics->setParams($parameters) // Set the parameters
                ->setCount(1) // Initialize count to 1
                ->setLastAccessed(null);
        }

        // Persist the updated or new entity and flush changes to the database
        $this->entityManager->persist($statistics);
        $this->entityManager->flush();
    }

    /**
     * Retrieves the most frequent request based on the stored statistics.
     *
     * This method calls the custom repository method to find the RequestStatistic entity
     * with the highest count, representing the most frequently requested parameters.
     *
     * @return RequestStatistic|null The most frequent RequestStatistic or null if no data is found.
     */
    public function getMostFrequentRequest(): ?RequestStatistic
    {
        // Use the repository to fetch the most frequent request based on stored statistics
        return $this->entityManager->getRepository(RequestStatistic::class)
            ->findMostFrequentRequest();
    }
}
