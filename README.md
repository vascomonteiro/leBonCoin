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
   docker compose -f docker-compose-leboncoin.yml up --build
   ```
   Application ready when output containers build shows:
   .....
   leboncoin_app      | [23-Mar-2025 22:59:54] NOTICE: fpm is running, pid 1 
   leboncoin_app      | [23-Mar-2025 22:59:54] NOTICE: ready to handle connections

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
docker exec -it leboncoin_app ./vendor/bin/phpunit tests
```
Tests cover:
- Controller functionality (ex., `FizzBuzzControllerTest`)
- DTO validation (e.g., `FizzBuzzRequestTest`)
- Service logic (e.g., `FizzBuzzService`)
---

NEW LebonCoin Backend Symfony/PHP on the way! 🚀

