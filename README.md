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
```bash
app/
├── Console/ # Custom artisan commands
├── Exceptions/ # Global exception handling
├── Http/
│ ├── Controllers/ # API controllers (v1, v2)
│ │ ├── V1/
│ │ │ ├── ActivityLoggerController.php
│ │ │ ├── TaskController.php
│ │ │ └── UserController.php
│ │ └── V2/ # Updated API version using middleware and authentication
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
```
### Key Architectural Layers

- **Controllers (V1, V2):** Handle incoming HTTP requests and route them to service methods.  
- **Services:** Contain business logic and orchestrate between repositories and controllers.  
- **Repositories:** Encapsulate database operations using Eloquent ORM.  
- **Interfaces:** Define contracts for repository and service classes to enforce dependency inversion.  
- **Models:** Represent database entities with defined relationships and fillable fields.  

---

## ⚙️ 3. Core Functional Modules

### 🧑‍💻 Users
- **Full CRUD:** Create, retrieve, update, and delete users via REST API endpoints following the controller–service–repository pattern.  
- **Password Security:** All passwords are securely hashed using `Hash::make()` before storage — never stored or returned in plain text.  
- **Validation:** Robust validation for registration and updates ensures:
  - Unique email enforcement  
  - Strong password requirements  
  - Validation on both create and update actions  
- **Authentication & Authorization:**  
  - Login generates a **Laravel Sanctum** token.  
  - All protected routes use `auth:sanctum` and a custom `restrictRole` middleware for fine-grained access control.  
  - All login attempts and errors are logged (IP and timestamp included; raw passwords are never logged).  
- **Standardized API Responses:** Clear JSON structures for successes, validation errors, and server-side failures — ensuring smooth frontend and mobile integration.

---

### ✅ Tasks
- **User Association:** Each task is linked to a user via `user_id` (foreign key). Only authenticated users can manage their own tasks.  
- **Fields:**  
  - `title` — string  
  - `priority` — enum (`low`, `medium`, `high`)  
  - `due` — date  
  - `status` — boolean (completion flag)  
- **Pagination:**  
  - Task listing endpoints implement Eloquent’s `paginate()` for scalable response sizes.  
  - Pagination metadata is included for client-side navigation.  
- **Security:**  
  - All task routes are protected via **Sanctum** tokens and middleware, ensuring only authorized users can perform CRUD actions.

---

### 🧾 Activity Logs
- **Tracking:** Logs all user actions on tasks — create, update, delete — with `user_id`, `task_id`, `action`, and timestamp.  
- **Analytics & Auditing:**  
  - Logs are queryable by admins for analytics or compliance monitoring.  
- **Immutable:**  
  - Append-only design ensures logs are never deleted or tampered with.  
- **Accessibility:**  
  - `/api/v2/logger` endpoints allow admins or privileged users to fetch all logs, filter by user/task, and audit activity.

---

### 🧠 Design Principles
- **Modern Laravel Architecture:**  
  - Layered structure with service and repository classes using dependency injection.  
- **Dependency Inversion:**  
  - All business logic uses contracts and the service container for flexibility and testability.  
- **Clean Separation:**  
  - Business logic and data access layers are fully decoupled for maintainability.  
- **Extensive Logging:**  
  - Major events — CRUD operations, authentication attempts, and results — are logged for transparency and debugging.

---

## 4. API Endpoints (v1)

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

## API Endpoints (v2)

| Method | Endpoint | Description |
|:--:|:--|:--|
| **POST** | `/api/login` | Authenticate user and generate access token |
| **GET** | `/api/v2/users` | List all users |
| **POST** | `/api/v2/users` | Create a new user |
| **GET** | `/api/v2/users/{id}` | Get a single user by ID |
| **PUT** | `/api/v2/users/{id}` | Update user details |
| **DELETE** | `/api/v2/users/{id}` | Delete a user |
| **GET** | `/api/v2/tasks` | List all tasks |
| **POST** | `/api/v2/tasks` | Create a new task |
| **GET** | `/api/v2/tasks/{id}` | Get task details by ID |
| **PUT** | `/api/v2/tasks/{id}` | Update task details |
| **DELETE** | `/api/v2/tasks/{id}` | Delete a task |
| **GET** | `/api/v2/logger` | Retrieve all activity logs |
| **GET** | `/api/v2/logger/{id}` | Get specific activity log by ID |

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

Validation is handled via **Form Requests** (`App\Http\Requests`), ensuring clean and centralized input validation.

### Common HTTP Response Codes
| Code | Meaning |
|------|----------|
| **200** | Success |
| **201** | Resource created |
| **404** | Not found |
| **422** | Validation error |
| **500** | Internal server error |

All API responses follow a **standardized JSON format**, ensuring consistent success and error handling across all controllers.

---

## 6. Security Practices

- Passwords are securely hashed using Laravel’s `Hash::make()`.  
- All input is validated for **type, format, and constraints**.  
- **CSRF** and **signature validation** are enforced via Laravel middleware.  
- The architecture is **future-ready** for integration with **Laravel Sanctum** or **Passport** authentication.

---

## 7. Scalability and Maintainability

- **Versioned APIs:** Supports `/v1` and `/v2` routes for structured evolution and backward compatibility.  
- **Pagination:** Implemented in all list endpoints via Eloquent’s `paginate()` for efficient large data handling.  
- **Loose Coupling:** Repositories are bound to interfaces through service providers, maintaining clean dependency inversion.  
- **Migrations:** Database schema versioning and evolution handled seamlessly via artisan commands.

---

## 8. Database Schema

### Users
| Field | Type | Description |
|-------|------|--------------|
| id | integer | Primary key |
| username | string | User’s name |
| email | string | Unique email address |
| password | string | Hashed password |

### Tasks
| Field | Type | Description |
|-------|------|--------------|
| id | integer | Primary key |
| user_id | integer | Foreign key reference to users |
| title | string | Task title |
| priority | enum | low / medium / high |
| status | boolean | Completion flag |
| due | date | Task due date |

### ActivityLogger
| Field | Type | Description |
|-------|------|--------------|
| id | integer | Primary key |
| user_id | integer | User performing the action |
| task_id | integer | Affected task |
| action | string | Performed action |
| created_at | timestamp | Log creation time |

---

## 9. Installation Guide

### Requirements
- PHP **8.2+**
- Composer
- MySQL **8.0+**
- Laravel **10.x**

### Setup

```bash
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
```
Note: API will be publicly available soon.

## 10. Testing

Use **Postman**, **Insomnia**, or `curl` to test API endpoints.  
All requests and responses use **JSON format** for consistency and interoperability.

### Example Request
POST /api/v1/tasks
Content-Type: application/json
```http
{
  "user_id": 1,
  "title": "Submit report",
  "priority": "high",
  "due": "2025-11-12"
}
```

## 11. Code Standards

- Complies with **PSR-4 autoloading** and **PSR-12 formatting**.  
- Service, repository, and interface bindings follow **dependency inversion principles**.  
- Fully **namespaced** for clarity, IDE support, and long-term maintainability.  

---

## 12. License

This project is licensed under the **MIT License**.

---

## Summary

**QuirkTasker** represents a real-world, production-ready **Laravel REST API** implementation.  
It emphasizes:

- Versioned REST endpoints  
- Maintainable and scalable architecture  
- Strong adherence to security and validation best practices  

The structure is ideal for **enterprise APIs**, **mobile backends**, or **modern web client integrations**.

