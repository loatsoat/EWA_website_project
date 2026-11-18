# EWA Project
This repository provides a reproducible Apache/PHP/MariaDB environment for the EWA course, including practical exercises, lecture demos, and previous exams.
It matters because students can run the same stack locally without installing or configuring a web server and database by hand.

[![CI](https://github.com/loatsoat/EWA_project/actions/workflows/ci.yml/badge.svg)](https://github.com/loatsoat/EWA_project/actions/workflows/ci.yml)

## What problem does it solve?

Web-development exercises often fail before the first line of application code because PHP, Apache, database credentials, and imported schemas differ between machines. Docker Compose keeps those services and the database seed files together, while the `src` directory remains a live-mounted workspace.

## Demo

After startup, open the live local demo at [http://localhost](http://localhost). The database administration UI is available at [http://localhost:8085](http://localhost:8085).

## Quick start

### Prerequisites

- [Docker Desktop](https://docs.docker.com/desktop/) with Docker Compose v2
- Git
- Ports `80`, `3306`, and `8085` available on the host

### Clone, install, and run

```bash
git clone https://github.com/loatsoat/EWA_project.git
cd EWA_project
cp .env.example .env
docker compose up -d
```

On Windows PowerShell, use `Copy-Item .env.example .env` instead of `cp`.

Verify the installation:

```bash
docker compose ps
curl http://localhost
```

Visit [http://localhost](http://localhost), then stop the stack with:

```bash
docker compose down
```

The MariaDB volume is intentionally persistent. To recreate the seeded database from scratch, run `docker compose down -v` and then `docker compose up -d`.

## Architecture

```text
EWA_project/
├── docker-compose.yml        # Apache/PHP, MariaDB, and phpMyAdmin services
├── php-apache/               # Apache image and debugging configuration
├── mariadb/mariadb.setup/    # Alphabetically imported SQL seed files
├── src/
│   ├── Praktikum/            # Course practicals and MVC examples
│   ├── Klausuren/            # Past exams, solutions, and supplied assets
│   ├── EWA_Framework/        # Small MVC framework example
│   └── index.php             # Landing page served at localhost
├── tests/                    # Repository smoke checks
└── .github/workflows/        # Automated PHP syntax and Compose checks
```

## Design decisions

- **Docker Compose:** makes the multi-service environment reproducible and avoids host-specific PHP/Apache/MariaDB setup.
- **Bind-mounted `src`:** changes are immediately visible in the web container, which is essential for an exercise repository.
- **Checked-in SQL seeds:** database examples are reviewable and can be recreated after deleting the named volume.
- **Historical folders remain separate:** exercises and exams are preserved as teaching material instead of being forced into one application architecture.
- **Environment-based credentials:** `.env` is local-only; `.env.example` documents development defaults without requiring secrets in the repository.

## Development and troubleshooting

Useful shortcuts are available in the [Makefile](Makefile):

```text
make start    Start the services
make stop     Stop the services
make test     Run PHP syntax checks
make build    Recreate containers and the database volume
make console  Open a shell in the Apache container
```

Run the validation directly on Windows with:

```powershell
pwsh -File tests/php-lint.ps1
```

If a service does not start, inspect its logs with `docker compose logs <service>`. Port conflicts are the most common cause; change the host-side port mappings in `docker-compose.yml` if required. SQL import errors prevent MariaDB from becoming ready and should be fixed in the reported seed file before rebuilding.

The containers are intended for local coursework, not production deployment. Keep the stack bound to localhost and stop it when it is not in use.

## License

The repository is released under the [MIT License](LICENSE). Third-party course materials retain their original rights.
