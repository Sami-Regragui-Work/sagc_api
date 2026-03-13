# Authentication System and Profile Management

A RESTful API built with **Laravel 12** providing JWT-based authentication and user profile management.

**Author:** Sami Regragui

---

## Table of Contents

- <a href="#stack">Stack</a>
- <a href="#requirements">Requirements</a>
- <a href="#installation">Installation</a>
- <a href="#configuration">Configuration</a>
- <a href="#database">Database Setup</a>
- <a href="#launch">Launch</a>
- <a href="#api-docs">API Documentation</a>
- <a href="#routes">Route Overview</a>

---

<section id="stack">

## Stack

| Layer | Technology |
|---|---|
| Language | PHP 8.5.3 |
| Framework | Laravel 12.54.1 |
| Authentication | JWT via `tymon/jwt-auth` |
| Database | MySQL |
| API Documentation | Swagger UI via `darkaonline/l5-swagger` |

</section>

---

<section id="requirements">

## Requirements

- PHP >= 8.2
- Composer
- MySQL
- `php artisan serve` (no Docker or Sail required)

</section>

---

<section id="installation">

## Installation

**1. Clone the repository**

```bash
git clone https://github.com/your-username/your-repo.git
cd your-repo
```

**2. Install PHP dependencies**

```bash
composer install
```

**3. Copy the environment file**

```bash
cp .env.example .env
```

**4. Generate the application key**

```bash
php artisan key:generate
```

**5. Generate the JWT secret**

```bash
php artisan jwt:secret
```

</section>

---

<section id="configuration">

## Configuration

Open `.env` and fill in the following values:

```env
APP_NAME="Authentication System and Profile Management"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

L5_SWAGGER_GENERATE_ALWAYS=false
L5_FORMAT_TO_USE_FOR_DOCS=yaml
```

</section>

---

<section id="database">

## Database Setup

**1. Create the database** in MySQL:

```sql
CREATE DATABASE your_database_name;
```

**2. Run the migrations**

```bash
php artisan migrate
```

</section>

---

<section id="launch">

## Launch

```bash
php artisan serve
```

The API is now available at `http://localhost:8000/api`.

</section>

---

<section id="api-docs">

## API Documentation

This project uses **Swagger UI** served by [`darkaonline/l5-swagger`](https://github.com/DarkaOnLine/L5-Swagger), a Laravel wrapper around the OpenAPI standard. It was chosen because it integrates directly into the Laravel application with no external tools required — the documentation is accessible from the same server as the API and supports live "Try it out" testing from the browser.

The OpenAPI specification file is located at:

```
storage/api-docs/api-docs.yaml
```

**Access the documentation at:**

```
http://localhost:8000/api/documentation
```

### How to authenticate in Swagger UI

1. Call `POST /register` or `POST /login` using the **Try it out** button
2. Copy the `token` value from the response
3. Click the **Authorize** button at the top of the page
4. Enter `Bearer <your_token>` in the value field and click **Authorize**
5. All protected routes will now include the token automatically

</section>

---

<section id="routes">

## Route Overview

### Public routes — no token required

| Method | Endpoint | Description |
|---|---|---|
| POST | `/api/register` | Create a new account |
| POST | `/api/login` | Login and receive a JWT token |

### Protected routes — `Authorization: Bearer <token>` header required

| Method | Endpoint | Description |
|---|---|---|
| POST | `/api/logout` | Invalidate the current token |
| POST | `/api/refresh` | Issue a new token |
| GET | `/api/me` | Get the authenticated user's profile |
| PUT | `/api/me` | Update profile fields |
| PUT | `/api/me/password` | Change password |
| DELETE | `/api/me` | Delete account |

For full request/response details, see the [API documentation](#api-docs).

</section>
