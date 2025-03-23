<?php

namespace App\Service;

use App\DTO\FizzBuzzRequest;

class FizzBuzzService
{
    /**
     * Generates a FizzBuzz sequence based on the provided DTO values.
     *
     * This method iterates from 1 to the specified limit and checks each number.
     * - If the number is divisible by the value of int1, it appends str1 to the output.
     * - If the number is divisible by the value of int2, it appends str2 to the output.
     * - If the number is divisible by both, it appends both str1 and str2.
     * - If the number is divisible by neither, it adds the number itself to the output.
     *
     * @param FizzBuzzRequest $dto The data transfer object containing the values for int1, int2, limit, str1, and str2.
     * @return array The generated FizzBuzz sequence.
     */
    public function generate(FizzBuzzRequest $dto): array
    {
        // Extract values from the DTO
        $int1 = $dto->getInt1();  // First integer for the FizzBuzz condition
        $int2 = $dto->getInt2();  // Second integer for the FizzBuzz condition
        $limit = $dto->getLimit();  // The limit of numbers to iterate over
        $str1 = $dto->getStr1();  // The string to append for multiples of int1
        $str2 = $dto->getStr2();  // The string to append for multiples of int2
        
        // Initialize an array to store the FizzBuzz results
        $result = [];

        // Loop through numbers from 1 to the limit
        for ($i = 1; $i <= $limit; $i++) {
            $output = '';  // Initialize an empty string to store the result for the current number

            // Check if the number is divisible by int1 and append str1 if true
            if ($i % $int1 === 0) {
                $output .= $str1;  // Append str1 if multiple of int1
            }

            // Check if the number is divisible by int2 and append str2 if true
            if ($i % $int2 === 0) {
                $output .= $str2;  // Append str2 if multiple of int2
            }

            // If the output is still empty, add the number itself as a string
            if ($output === '') {
                $output = (string) $i;  // If neither, keep the number itself
            }

            // Add the current result to the result array
            $result[] = $output;
        }

        // Return the completed FizzBuzz result array
        return $result;
    }
}
