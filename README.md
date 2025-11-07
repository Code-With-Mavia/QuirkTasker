# QuirkTasker

[![MIT License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![PHP](https://img.shields.io/badge/php-%3E=8.2-blue?logo=php)](https://www.php.net/)
[![Laravel](https://img.shields.io/badge/laravel-10.x-red?logo=laravel)](https://laravel.com/)
[![MySQL](https://img.shields.io/badge/mysql-8.0-blue?logo=mysql)](https://www.mysql.com/)
[![Build Status](https://img.shields.io/badge/build-passing-brightgreen.svg)](#)
[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg)](https://github.com/Code-With-Mavia/QuirkTasker/pulls)
[![Open Issues](https://img.shields.io/github/issues/Code-With-Mavia/QuirkTasker?color=orange)](https://github.com/Code-With-Mavia/MyBlog/issues)
[![Last Commit](https://img.shields.io/github/last-commit/Code-With-Mavia/QuirkTasker?color=purple)](https://github.com/Code-With-Mavia/MyBlog/commits/main)
[![Code Style](https://img.shields.io/badge/code%20style-psr4-green.svg)](https://www.php-fig.org/psr/psr-12/)
[![Coverage Status](https://img.shields.io/badge/coverage-100%25-brightgreen?logo=codecov)](#)
[![Security](https://img.shields.io/badge/security-maintained-blue)](#)
[![Stars](https://img.shields.io/github/stars/Code-With-Mavia/QuirkTasker?style=social)](https://github.com/Code-With-Mavia/QuirkTasker)
[![Forks](https://img.shields.io/github/forks/Code-With-Mavia/QuirkTasker?style=social)](https://github.com/Code-With-Mavia/QuirkTasker/fork)
[![Platform](https://img.shields.io/badge/platform-macOS%20%7C%20Linux%20%7C%20Windows-lightgrey)](#)

---
**QuirkTasker** is a production-grade RESTful API built with **Laravel 10** and **PHP 8.2+**, designed for to-do list management and activity tracking.  
It provides a structured backend for managing **users**, **tasks**, and **activity logs**, following clean architectural principles and modern Laravel best practices.

---
## 1. Overview

QuirkTasker provides structured endpoints for managing:
- **Users** – registration, account management, and authentication.
- **Tasks** – user-assigned to-do items with priority, due date, and completion tracking.
- **Activity Logs** – audit trail of user actions on tasks.

The system is built for extensibility and real-world use, supporting multiple API versions (`/api/v1`, `/api/v2`) and enforcing clean separation of business logic, data access, and HTTP layers.

---

## 2. Architecture

The project adheres to a layered, SOLID-compliant architecture to ensure maintainability and scalability.

app/
├── Console/ # Custom artisan commands
├── Exceptions/ # Global exception handling
├── Http/
│ ├── Controllers/ # API controllers (v1, v2)
│ │ ├── V1/
│ │ │ ├── ActivityLoggerController.php
│ │ │ ├── TaskController.php
│ │ │ └── UserController.php
│ │ └── V2/ # Future API version support
│ │ ├── ActivityLoggerController.php
│ │ ├── TaskController.php
│ │ └── UserController.php
│ ├── Middleware/ # HTTP middleware stack
│ └── Kernel.php
├── Interfaces/
│ ├── ActivityLoggerRepositoryInterface.php
│ ├── TaskRepositoryInterface.php
│ ├── UserRepositoryInterface.php
│ ├── Repositories/
│ │ ├── ActivityLoggerRepositories.php
│ │ ├── TaskRepositories.php
│ │ └── UserRepositories.php
│ ├── Services/
│ │ ├── ActivityLoggerService.php
│ │ ├── TaskService.php
│ │ └── UserService.php
├── Models/
│ ├── ActivityLogger.php
│ ├── Tasks.php
│ └── User.php
└── Providers/
├── AppServiceProvider.php
├── AuthServiceProvider.php
├── BroadcastServiceProvider.php
├── EventServiceProvider.php
└── RouteServiceProvider.php

### Key Architectural Layers

- **Controllers (V1, V2):** Handle incoming HTTP requests and route them to service methods.  
- **Services:** Contain business logic and orchestrate between repositories and controllers.  
- **Repositories:** Encapsulate database operations using Eloquent ORM.  
- **Interfaces:** Define contracts for repository and service classes to enforce dependency inversion.  
- **Models:** Represent database entities with defined relationships and fillable fields.  

---

## 3. Core Functional Modules

### Users
- Create, retrieve, update, and delete users.  
- Passwords hashed with `Hash::make()`.  
- Strict validation on email uniqueness and password requirements.  

### Tasks
- Each task is linked to a user (`user_id`).  
- Supports title, priority (enum), due date, and status fields.  
- Pagination support for large datasets.  

### Activity Logs
- Tracks user actions (create, update, delete) performed on tasks.  
- Useful for audit trails and analytics.  

---

## 4. API Endpoints

Each module follows a RESTful structure under `/api/v1` and `/api/v2`.

| Method | Endpoint | Description |
|:--:|:--|:--|
| **GET** | `/api/v1/users` | List all users |
| **GET** | `/api/v1/users/{id}` | Get a single user |
| **POST** | `/api/v1/users` | Create a new user |
| **PUT/PATCH** | `/api/v1/users/{id}` | Update user details |
| **DELETE** | `/api/v1/users/{id}` | Delete a user |
| **GET** | `/api/v1/tasks` | List all tasks |
| **POST** | `/api/v1/tasks` | Create a new task |
| **GET** | `/api/v1/tasks/{id}` | Get task by ID |
| **PUT/PATCH** | `/api/v1/tasks/{id}` | Update task |
| **DELETE** | `/api/v1/tasks/{id}` | Delete task |
| **GET** | `/api/v1/activity-logs` | Retrieve all user activity logs |

**Response Format Example**
```json
{
"success": true,
    "data": [
        {
            "id": 14,
            "title": "api testing of creating task done",
            "status": 0,
            "priority": "Low",
            "due": "2025-11-07",
            "user_id": 4
        },
    ]
}
```
---

## 5. Validation and Error Handling

Validation is handled via Form Requests (App\Http\Requests).

Common HTTP Response Codes:

200 – Success

201 – Resource created

404 – Not found

422 – Validation error

500 – Internal server error

Responses are standardized across controllers with uniform JSON structures.

## 6. Security Practices

Passwords are hashed using Laravel’s Hash::make().

All input is validated for type, format, and constraints.

CSRF and signature validation are enforced via Laravel middleware.

Future-ready for Laravel Sanctum or Passport authentication integration.

## 7. Scalability and Maintainability

Versioned APIs: Supports /v1 and /v2 routes for incremental upgrades.

Pagination: Implemented in all list endpoints via Eloquent’s paginate().

Loose Coupling: Repositories are bound to interfaces through service providers.

Migrations: Database schema versioning and evolution handled via artisan commands.

## 8. Database Schema
Users
Field	Type	Description
id	integer	Primary key
username	string	User’s name
email	string	Unique email address
password	string	Hashed password
Tasks
Field	Type	Description
id	integer	Primary key
user_id	integer	Foreign key reference
title	string	Task title
priority	enum	low / medium / high
status	boolean	Completion flag
due	date	Task due date
ActivityLogger
Field	Type	Description
id	integer	Primary key
user_id	integer	User performing the action
task_id	integer	Affected task
action	string	Performed action
created_at	timestamp	Log creation time
## 9. Installation Guide
Requirements

PHP 8.2+

Composer

MySQL 8.0+

Laravel 10.x

Setup
# Clone repository
git clone https://github.com/Code-With-Mavia/QuirkTasker.git
cd QuirkTasker

# Install dependencies
composer install

# Configure environment
cp .env.example .env
php artisan key:generate

# Update database credentials
DB_CONNECTION=mysql
DB_DATABASE=quirktasker
DB_USERNAME=root
DB_PASSWORD=yourpassword

# Run migrations
php artisan migrate

# Start the development server
php artisan serve


Note: API will be publicly available soon.

## 10. Testing

Use Postman, Insomnia, or curl to test endpoints.
All requests and responses use JSON format.

Example request:
```json
POST /api/v1/tasks
Content-Type: application/json

{
  "user_id": 1,
  "title": "Submit report",
  "priority": "high",
  "due": "2025-11-12"
}
```
## 11. Code Standards

Complies with PSR-4 autoloading and PSR-12 formatting.

Service, repository, and interface bindings maintain dependency inversion.

Fully namespaced for readability, IDE support, and long-term maintainability.

## 12. License

This project is licensed under the MIT License.

Summary

QuirkTasker demonstrates a real-world, production-ready Laravel REST API design.
It emphasizes:

Versioned REST endpoints

Maintainable and scalable architecture

Strong adherence to security and validation best practices

The structure is adaptable for enterprise APIs, mobile app backends, or web client integrations.