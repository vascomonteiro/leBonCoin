<?php
namespace App\Tests\Controller;

use App\Service\FizzBuzzService;
use App\Service\StatisticsService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class FizzBuzzControllerTest extends WebTestCase
{
    private $client;
    private $fizzBuzzServiceMock;
    private $statisticsServiceMock;

    protected function setUp(): void
    {
        // Create the client for making requests
        $this->client = static::createClient();

        // Mock the FizzBuzzService
        $this->fizzBuzzServiceMock = $this->createMock(FizzBuzzService::class);
        
        // Mock the StatisticsService
        $this->statisticsServiceMock = $this->createMock(StatisticsService::class);

        // Overriding the services in the container
        $this->client->getContainer()->set(FizzBuzzService::class, $this->fizzBuzzServiceMock);
        $this->client->getContainer()->set(StatisticsService::class, $this->statisticsServiceMock);
    }

    public function testFizzBuzzControllerValidData(): void
    {
        // Define test parameters
        $parameters = [
            'int1' => 3,
            'int2' => 5,
            'limit' => 10,
            'str1' => 'Fizz',
            'str2' => 'Buzz'
        ];

        // Expected result
        $expectedResult = ["1", "2", "Fizz", "4", "Buzz", "Fizz", "7", "8", "Fizz", "Buzz"];

        // Mock the FizzBuzzService generate method
        $this->fizzBuzzServiceMock
            ->expects($this->once())
            ->method('generate')
            ->with($this->callback(fn($dto) => 
                $dto->getInt1() === 3 &&
                $dto->getInt2() === 5 &&
                $dto->getLimit() === 10 &&
                $dto->getStr1() === 'Fizz' &&
                $dto->getStr2() === 'Buzz'
            ))
            ->willReturn($expectedResult);

        // Mock the statistics service
        $this->statisticsServiceMock
            ->expects($this->once())
            ->method('incrementRequestCount')
            ->with($parameters);

        // Simulate a valid GET request
        $this->client->request('GET', '/fizzbuzz', [
            'int1' => '3',
            'int2' => '5',
            'limit' => '10',
            'str1' => 'Fizz',
            'str2' => 'Buzz'
        ]);

        // Get the response
        $response = $this->client->getResponse();

        // Ensure response is successful
        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());

        // Decode JSON and validate structure
        $data = json_decode($response->getContent(), true);
        $this->assertIsArray($data);

        // Assert that the output matches the expected FizzBuzz result
        $this->assertSame($expectedResult, $data);
    }

    public function testFizzBuzzControllerInvalidData(): void
    {
        // Simulate an invalid GET request (passing 'abc' instead of a valid integer for int1)
        $this->client->request('GET', '/fizzbuzz', [
            'int1' => 'abc',
            'int2' => '5',
            'limit' => '100',
            'str1' => 'Fizz',
            'str2' => 'Buzz'
        ]);

        // Get the response
        $response = $this->client->getResponse();

        // Assert the response status is 400 Bad Request
        $this->assertResponseStatusCodeSame(JsonResponse::HTTP_BAD_REQUEST);
        $this->assertJson($response->getContent());

        // Decode JSON response
        $data = json_decode($response->getContent(), true);
        $this->assertIsArray($data);

        // Ensure the response contains an error message
        $this->assertArrayHasKey('error', $data);
        $this->assertStringContainsString('must be a positive integer', $data['error'][0]);
    }

    public function testGetStatistics(): void
    {
        // Define expected statistics response
        $expectedParams = [
            'int1' => 3,
            'int2' => 5,
            'limit' => 10,
            'str1' => 'Fizz',
            'str2' => 'Buzz'
        ];
    
        // Create a mock for RequestStatistic entity
        $statisticsMock = $this->createMock(\App\Entity\RequestStatistic::class);
        $statisticsMock->method('getParams')->willReturn($expectedParams); // Return array
        $statisticsMock->method('getCount')->willReturn(5); // Return an integer
    
        // Mock the statistics service to return the mocked entity
        $this->statisticsServiceMock
            ->expects($this->once())
            ->method('getMostFrequentRequest')
            ->willReturn($statisticsMock);
    
        // Make a request to the /statistics endpoint
        $this->client->request('GET', '/statistics');
    
        // Get the response
        $response = $this->client->getResponse();
    
        // Ensure response is successful
        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());
    
        // Decode JSON response
        $data = json_decode($response->getContent(), true);
        $this->assertIsArray($data);
    
        // Validate the response data
        $this->assertSame([
            'params' => $expectedParams,  // Ensure this matches the expected array
            'count' => 5
        ], $data);
    }
    
    public function testGetStatisticsWhenNoData(): void
    {
        // Mock the statistics service to return null
        $this->statisticsServiceMock
            ->expects($this->once())
            ->method('getMostFrequentRequest')
            ->willReturn(null);

        // Make a request to the /statistics endpoint
        $this->client->request('GET', '/statistics');

        // Get the response
        $response = $this->client->getResponse();

        // Assert the response status is 404 Not Found
        $this->assertResponseStatusCodeSame(JsonResponse::HTTP_NOT_FOUND);
        $this->assertJson($response->getContent());

        // Decode JSON response
        $data = json_decode($response->getContent(), true);
        $this->assertIsArray($data);

        // Validate the response message
        $this->assertArrayHasKey('message', $data);
        $this->assertSame('No requests found', $data['message']);
    }
}
