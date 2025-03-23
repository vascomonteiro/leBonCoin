<?php
namespace App\Tests\DTO;

use App\DTO\FizzBuzzRequest;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class FizzBuzzRequestTest extends KernelTestCase
{
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        self::bootKernel();  // Initialize the kernel
        $this->validator = self::getContainer()->get('validator');  // Use getContainer() to access the container
    }

    public function testValidFizzBuzzRequest(): void
    {
        $dto = new FizzBuzzRequest('3', '5', '100', 'Fizz', 'Buzz');
        $errors = $this->validator->validate($dto);

        // Assert no validation errors
        $this->assertCount(0, $errors);
    }

    public function testInvalidFizzBuzzRequestWithNonNumericInt1(): void
    {
        $dto = new FizzBuzzRequest('abc', '5', '100', 'Fizz', 'Buzz');
        $errors = $this->validator->validate($dto);

        // Assert validation errors
        $this->assertCount(1, $errors);
        $this->assertEquals('The int1 value \'"abc"\' must be a positive integer.', $errors[0]->getMessage());
    }

    public function testInvalidFizzBuzzRequestWithMissingInt1(): void
    {
        $dto = new FizzBuzzRequest(null, '5', '100', 'Fizz', 'Buzz');
        $errors = $this->validator->validate($dto);

        // Assert validation errors
        $this->assertCount(1, $errors);
        $this->assertEquals('Missing parameter/value int1.', $errors[0]->getMessage());
    }

    public function testInvalidFizzBuzzRequestWithNegativeInt2(): void
    {
        $dto = new FizzBuzzRequest('3', '-5', '100', 'Fizz', 'Buzz');
        $errors = $this->validator->validate($dto);

        // Assert validation errors
        $this->assertCount(1, $errors);
        $this->assertEquals('The int2 value \'"-5"\' must be a positive integer.', $errors[0]->getMessage()); // Negative number fails
    }

    public function testInvalidFizzBuzzRequestWithNonNumericLimit(): void
    {
        $dto = new FizzBuzzRequest('3', '5', 'abc', 'Fizz', 'Buzz');
        $errors = $this->validator->validate($dto);

        // Assert validation errors
        $this->assertCount(1, $errors);
        $this->assertEquals('The limit value \'"abc"\' must be a positive integer.', $errors[0]->getMessage());
    }
}
