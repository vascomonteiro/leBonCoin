<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Data Transfer Object (DTO) for FizzBuzz request parameters.
 * 
 * This class is used to validate and store user inputs for the FizzBuzz application.
 */
class FizzBuzzRequest
{
    /**
     * First integer for the FizzBuzz calculation.
     *
     * @var string|null
     */
    #[Assert\NotBlank(message: "Missing parameter/value int1.")]
    #[Assert\Regex("/^\d+$/", message: "The int1 value '{{ value }}' must be a positive integer.")]
    public ?string $int1;

    /**
     * Second integer for the FizzBuzz calculation.
     *
     * @var string|null
     */
    #[Assert\NotBlank(message: "Missing parameter/value int2.")]
    #[Assert\Regex("/^\d+$/", message: "The int2 value '{{ value }}' must be a positive integer.")]
    public ?string $int2;

    /**
     * Limit up to which the FizzBuzz sequence should be generated.
     *
     * @var string|null
     */
    #[Assert\NotBlank(message: "Missing parameter/value limit.")]
    #[Assert\Regex("/^\d+$/", message: "The limit value '{{ value }}' must be a positive integer.")]
    public ?string $limit;

    /**
     * String to replace multiples of int1.
     *
     * @var string|null
     */
    #[Assert\NotBlank(message: "Missing parameter/value ex: str1=fizz.")]
    public ?string $str1;

    /**
     * String to replace multiples of int2.
     *
     * @var string|null
     */
    #[Assert\NotBlank(message: "Missing parameter/value ex: str2=buzz.")]
    public ?string $str2;

    /**
     * Constructor for FizzBuzzRequest.
     *
     * @param string|null $int1 First integer (string representation)
     * @param string|null $int2 Second integer (string representation)
     * @param string|null $limit Upper limit (string representation)
     * @param string|null $str1 Replacement string for multiples of int1
     * @param string|null $str2 Replacement string for multiples of int2
     */
    public function __construct(?string $int1, ?string $int2, ?string $limit, ?string $str1, ?string $str2)
    {
        $this->int1 = $int1;
        $this->int2 = $int2;
        $this->limit = $limit;
        $this->str1 = $str1;
        $this->str2 = $str2;
    }

    /**
     * Get int1 as an integer.
     *
     * @return int
     */
    public function getInt1(): int
    {
        return (int) $this->int1;
    }

    /**
     * Get int2 as an integer.
     *
     * @return int
     */
    public function getInt2(): int
    {
        return (int) $this->int2;
    }

    /**
     * Get limit as an integer.
     *
     * @return int
     */
    public function getLimit(): int
    {
        return (int) $this->limit;
    }

    /**
     * Get str1 as a string.
     *
     * @return string
     */
    public function getStr1(): string
    {
        return $this->str1;
    }

    /**
     * Get str2 as a string.
     *
     * @return string
     */
    public function getStr2(): string
    {
        return $this->str2;
    }

    /**
     * Convert the DTO to an associative array.
     *
     * @return array<string, int|string>
     */
    public function toArray(): array
    {
        return [
            'int1' => $this->getInt1(),
            'int2' => $this->getInt2(),
            'limit' => $this->getLimit(),
            'str1' => $this->getStr1(),
            'str2' => $this->getStr2(),
        ];
    }
}
