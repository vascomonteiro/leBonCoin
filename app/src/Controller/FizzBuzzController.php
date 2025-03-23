<?php

namespace App\Controller;

use App\DTO\FizzBuzzRequest;
use App\Repository\RequestStatisticRepository;
use App\Service\FizzBuzzService;
use App\Service\StatisticsService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FizzBuzzController extends AbstractController
{
    public function __construct(
        private FizzBuzzService $fizzBuzzService, 
        private StatisticsService $statisticsService, 
        private ValidatorInterface $validator
    ) {}

    /**
     * Generate a FizzBuzz sequence based on user input.
     *
     * @param Request $request The HTTP request containing query parameters
     * @return JsonResponse The FizzBuzz result in JSON format
     * 
     * #[Route('/fizzbuzz', methods: ['GET'])]
     */
    #[Route('/fizzbuzz', methods: ['GET'])]
    public function fizzbuzz(Request $request): JsonResponse
    {
        $dto = new FizzBuzzRequest(
            $request->query->get('int1'),
            $request->query->get('int2'),
            $request->query->get('limit'),
            $request->query->get('str1'),
            $request->query->get('str2')
        );

        // Validate the DTO
        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            // Return validation errors as a response
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            
            return new JsonResponse(['error' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Generate the FizzBuzz result
        $result = $this->fizzBuzzService->generate($dto);
        $parameters = $dto->toArray();

        // Increment the request count in statistics
        $this->statisticsService->incrementRequestCount($parameters);

        return new JsonResponse($result);
    }

    /**
     * Get statistics on the most frequent FizzBuzz request.
     *
     * @param RequestStatisticRepository $repository Repository for request statistics
     * @return JsonResponse The statistics data in JSON format
     * 
     * #[Route('/statistics', methods: ['GET'])]
     */
    #[Route('/statistics', methods: ['GET'])]
    public function getStatistics(RequestStatisticRepository $repository): JsonResponse
    {
        // Retrieve the most frequent request statistics
        $statistics = $this->statisticsService->getMostFrequentRequest();
    
        if (!$statistics) {
            return new JsonResponse(['message' => 'No requests found'], JsonResponse::HTTP_NOT_FOUND);
        }
    
        return new JsonResponse([
            'params' => $statistics->getParams(),
            'count' => $statistics->getCount(),
        ]);
    }
}
