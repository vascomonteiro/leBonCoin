# leBonCoin

## 🚀 Quick Start

### Prerequisites
Make sure you have the following installed:
- **Docker & Docker Compose**
- **PHP 8.2+** (if running without Docker)
- **Composer**

### Installation Steps
1. Clone the repository:
   ```bash
   git clone https://github.com/vascomonteiro/leBonCoin.git
   cd leBonCoin
   ```
2. Start the application with Docker:
   ```bash
   docker-compose up -d --build
   ```
3. The application should now be running at:
   - Backend (Symfony): `http://localhost:8080`

## 🛠️ Technologies Used
- **Symfony 6.4** (PHP Framework)
- **PHP 8.3+**
- **Docker & Docker Compose**
- **Nginx** (Web server)
- **MariaDB** (Database)
- **PHPUnit** (Testing)

## 📌 SOLID Principles & Best Practices
This project follows **SOLID** principles:
- **Single Responsibility Principle (SRP)**: Each class has one responsibility (e.g., `FizzBuzzService` only handles logic, not request validation).
- **Open/Closed Principle (OCP)**: The system allows adding new features without modifying existing code.
- **Liskov Substitution Principle (LSP)**: Classes in the codebase can be substituted without breaking functionality.
- **Interface Segregation Principle (ISP)**: Small, specific interfaces are used instead of a large monolithic one.
- **Dependency Inversion Principle (DIP)**: Dependencies are injected via services instead of being hardcoded.

Additional best practices:
- **DTOs (Data Transfer Objects)** for structured request handling.
- **Repository Pattern** for database access.
- **Environment variables** for configuration management.
- **SQL Injection support Doctrine** for security.

## 🧪 Testing with PHPUnit
Unit and functional tests ensure stability. To run tests:
```bash
# Run tests inside the container
docker exec -it leboncoin-php-fpm php bin/phpunit
```
Tests cover:
- Controller functionality (ex., `FizzBuzzControllerTest`)
- DTO validation (e.g., `FizzBuzzRequestTest`)
- Service logic (e.g., `FizzBuzzService`)
---

## Test Summary

### FizzBuzzControllerTest.php

| **Method Name**                      | **Description**                                                                                                                                                        | **Test**                                                                                     | **Output**                                                                                                                                                                                        |
|--------------------------------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------|----------------------------------------------------------------------------------------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `testFizzBuzzControllerValidData`    | Tests the valid data scenario for the FizzBuzz controller. It simulates a GET request with valid parameters and verifies the correct FizzBuzz sequence.                   | Mock `FizzBuzzService` to generate a sequence. Verify response contains the expected FizzBuzz result.  | JSON response with FizzBuzz result (e.g., `["1", "2", "Fizz", "4", "Buzz", "Fizz", "7", "8", "Fizz", "Buzz"]`). Status 200 OK.                                                             |
| `testFizzBuzzControllerInvalidData`  | Tests the scenario where invalid data is provided (e.g., non-integer `int1`), simulating a GET request and expecting an error response.                                 | Simulate GET request with invalid data (`abc` for `int1`). Assert error response.             | JSON error message, e.g., `{"error":["int1 must be a positive integer"]}`, Status 400 Bad Request.                                                                                           |
| `testGetStatistics`                  | Tests the scenario where statistics are fetched successfully from the statistics service.                                                                               | Mock `StatisticsService` to return statistics. Verify response matches expected statistics.      | JSON response containing statistics with `params` and `count`, e.g., `{"params":{"int1":3,"int2":5,"limit":10,"str1":"Fizz","str2":"Buzz"},"count":5}`, Status 200 OK.                          |
| `testGetStatisticsWhenNoData`        | Tests the scenario where no statistics data is available, expecting a "not found" response.                                                                            | Mock `StatisticsService` to return null. Simulate GET request for `/statistics`.               | JSON response with message `{"message":"No requests found"}`, Status 404 Not Found.                                                                                                            |


### FizzBuzzRequestTest.php

| **Method Name**                                      | **Description**                                                                                                         | **Test**                                                                                           | **Output**                                                                                                                                                                                   |
|------------------------------------------------------|-------------------------------------------------------------------------------------------------------------------------|--------------------------------------------------------------------------------------------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `testValidFizzBuzzRequest`                           | Tests the valid data scenario for `FizzBuzzRequest` DTO. Verifies no validation errors when valid data is provided.       | Create a valid `FizzBuzzRequest` DTO. Validate it and assert no validation errors.               | No validation errors. The count of errors will be 0.                                                                                                                                      |
| `testInvalidFizzBuzzRequestWithNonNumericInt1`       | Tests the scenario where `int1` is a non-numeric string, expecting a validation error.                                   | Create a `FizzBuzzRequest` DTO with a non-numeric `int1` value (`'abc'`). Assert validation error. | Validation error: `"The int1 value '\"abc\"' must be a positive integer."` Error count is 1.                                                                                              |
| `testInvalidFizzBuzzRequestWithMissingInt1`          | Tests the scenario where `int1` is missing, expecting a validation error for the missing parameter.                      | Create a `FizzBuzzRequest` DTO with `null` for `int1`. Assert validation error.                   | Validation error: `"Missing parameter/value int1."` Error count is 1.                                                                                                                     |
| `testInvalidFizzBuzzRequestWithNegativeInt2`         | Tests the scenario where `int2` is negative, expecting a validation error for negative integers.                          | Create a `FizzBuzzRequest` DTO with a negative `int2` value (`'-5'`). Assert validation error.     | Validation error: `"The int2 value '\"-5\"' must be a positive integer."` Error count is 1.                                                                                                |
| `testInvalidFizzBuzzRequestWithNonNumericLimit`      | Tests the scenario where `limit` is a non-numeric string, expecting a validation error.                                  | Create a `FizzBuzzRequest` DTO with a non-numeric `limit` value (`'abc'`). Assert validation error.| Validation error: `"The limit value '\"abc\"' must be a positive integer."` Error count is 1.                                                                                             |


NEW LebonCoin Backend Symfony/PHP on the way! 🚀

