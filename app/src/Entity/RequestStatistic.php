<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entity representing request statistics.
 *
 * This entity stores the parameters used in the request, the count of how many times
 * the request has been made, and the last time the request was accessed.
 */
#[ORM\Entity(repositoryClass: "App\Repository\RequestStatisticRepository")]
class RequestStatistic
{
    /**
     * Unique identifier for the request statistic.
     *
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    private $id;

    /**
     * Parameters associated with the request, stored as JSON.
     *
     * @var array
     */
    #[ORM\Column(type: "json")]
    private $params = [];

    /**
     * The count of how many times this request has been accessed.
     *
     * @var int
     */
    #[ORM\Column(type: "integer")]
    private $count = 0;

    /**
     * The last time this request was accessed.
     *
     * @var \DateTimeInterface|null
     */
    #[ORM\Column(type: "datetime")]
    private $last_accessed;

    /**
     * Get the ID of the request statistic.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the parameters associated with the request.
     *
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * Set the parameters for the request.
     *
     * @param array $params
     * @return self
     */
    public function setParams(array $params): self
    {
        $this->params = $params;
        return $this;
    }

    /**
     * Get the count of how many times the request has been accessed.
     *
     * @return int|null
     */
    public function getCount(): ?int
    {
        return $this->count;
    }

    /**
     * Set the count of how many times the request has been accessed.
     *
     * @param int $count
     * @return self
     */
    public function setCount(int $count): self
    {
        $this->count = $count;
        return $this;
    }

    /**
     * Get the last time the request was accessed.
     *
     * @return \DateTimeInterface|null
     */
    public function getLastAccessed(): ?\DateTimeInterface
    {
        return $this->last_accessed;
    }

    /**
     * Set the last time the request was accessed.
     *
     * @param \DateTimeInterface $last_accessed
     * @return self
     */
    public function setLastAccessed(?\DateTimeInterface $last_accessed): self
    {
        // If no value is provided, set to the current timestamp
        $this->last_accessed = $last_accessed ?: new \DateTime();
        return $this;
    }
}
