# EWA Website Project
A PHP/MariaDB pizza-ordering web app with customer, baker and driver views, served from a reproducible Docker stack.

[![CI](https://github.com/loatsoat/EWA_website_project/actions/workflows/ci.yml/badge.svg)](https://github.com/loatsoat/EWA_website_project/actions/workflows/ci.yml)

## What it does

A pizza service that covers the full order lifecycle:

- **Order page:** customers pick pizzas, see a live cart total, and place an order.
- **Customer page:** shows the status of their own orders and refreshes every 2 seconds through a JSON API (`fetch` + polling).
- **Baker page:** login-protected; marks pizzas as in the oven or ready.
- **Driver page:** login-protected; takes finished orders out for delivery and marks them delivered.

The app is built as a small hand-written MVC framework in plain PHP (no Composer packages): a front controller with a router, one controller per page, models for database access, and views with shared partials.

## Tech stack

- PHP 8 (strict types), Apache with `mod_rewrite`
- MariaDB, managed through phpMyAdmin
- Vanilla JavaScript for the cart and the live status updates
- Docker Compose for the whole environment
- GitHub Actions for PHP syntax checks and Compose validation

## Quick start

Requires [Docker Desktop](https://docs.docker.com/desktop/) with Compose v2 and free ports `80`, `3306` and `8085`.

```bash
git clone https://github.com/loatsoat/EWA_website_project.git
cd EWA_website_project
cp .env.example .env          # PowerShell: Copy-Item .env.example .env
docker compose up -d
```

- App: [http://localhost/Praktikum/Prak4/](http://localhost/Praktikum/Prak4/)
- phpMyAdmin: [http://localhost:8085](http://localhost:8085)

The database is seeded from `mariadb/mariadb.setup/` on first start. To reset it, run `docker compose down -v` and then `docker compose up -d`.

## Project structure

```text
EWA_website_project/
├── docker-compose.yml          # Apache/PHP, MariaDB and phpMyAdmin services
├── php-apache/                 # Web server image and configuration
├── mariadb/mariadb.setup/      # Pizzaservice schema and seed data
├── src/
│   ├── Praktikum/
│   │   ├── Prak1 … Prak4/      # The app built up step by step (Prak4 is the final version)
│   │   └── self_study*/        # Self-study variants
│   ├── EWA_Framework/          # Minimal MVC skeleton the app is based on
│   └── index.php               # Landing page at localhost
├── tests/php-lint.ps1          # PHP syntax check for every file
└── .github/workflows/ci.yml    # CI pipeline
```

Request flow in `Prak4`: `index.php` → `Router` → `*Controller` → `*Model` (MariaDB) → `View/*.view.php`.

## Design decisions

- **Own MVC instead of a framework:** keeps every layer visible and shows how routing, controllers and views fit together without framework magic.
- **Polling JSON API for live status:** `setInterval` + `fetch` every 2 seconds is simple and works without WebSockets on a plain Apache/PHP host.
- **Role-based access via sessions:** baker and driver pages check the session role in one `AuthHelper`, so access rules are not repeated in every controller.
- **Docker Compose:** the same Apache/PHP/MariaDB setup runs on any machine, and the seeded database can be rebuilt with one command.

## Running tests

```powershell
pwsh -File tests/php-lint.ps1
```

Or `make test`. CI runs the same check on every push.

## Limitations

- Baker and driver logins use fixed demo credentials, not a user table with hashed passwords.
- Status updates use polling rather than push, so there is up to a 2-second delay.
- Tests are syntax checks only; there are no unit or end-to-end tests yet.
- Intended for local use; the Docker setup is not hardened for production.
