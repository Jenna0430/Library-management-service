# Library Management Service

## 📘 Project Overview

The Library Management Service is a backend application designed to manage a library system. It allows for the management of books, users, and related library operations. The project is fully Dockerized, meaning anyone can run it without installing PHP, Nginx, or MySQL locally.

---

## 🧱 Tech Stack

- **PHP (Symfony)** – Application framework
- **MySQL 8.1** – Database
- **Nginx** – Web server / reverse proxy
- **Docker & Docker Compose** – Containerization
- **Doctrine ORM & Migrations** – Database management
- **Makefile** – Command simplification

---

## 🚀 Project Setup

### 1. Clone the repository
```bash
git clone https://github.com/Jenna0430/Library-management-service.git
cd Library-management-service
```

### 2. Build and start the containers
```bash
make up-build
```

### 3. Load data into the database
```bash
make load-data
```

### 4. Run migrations
```bash
make migrate
```

### 5. Generate migrations (if not already generated)
```bash
make migration-diff
```

### 6. Access the application

Open your browser and navigate to:
```
http://localhost
```

---

## 📁 Project Structure
```
Library/
├── bin/
│   └── console                 # Symfony CLI (commands, migrations, cache, etc.)
│
├── config/
│   ├── packages/               # Symfony bundle configurations
│   ├── routes/                 # Application routes
│   └── services.yaml           # Service container configuration
│
├── migrations/
│   └── Version*.php            # Doctrine database migrations
│
├── nginx/
│   └── default.conf            # Nginx virtual host configuration
│
├── public/
│   └── index.php               # Application entry point
│
├── src/
│   ├── Controller/             # Application controllers (HTTP endpoints)
│   ├── DataFixtures/           # Database seed data
│   ├── Entity/                 # Doctrine entities (database models)
│   ├── Repository/             # Database query logic
│   └── Kernel.php              # Symfony application kernel
│
├── var/
│   ├── cache/                  # Cache files (auto-generated)
│   └── log/                    # Application logs
│
├── vendor/                     # Composer dependencies (auto-generated)
│
├── .dockerignore               # Files ignored by Docker build
├── .editorconfig               # Code style rules
├── .env                        # Environment variables (DB, APP_ENV, etc.)
├── .gitignore                  # Git ignored files
├── composer.json               # PHP dependencies definition
├── composer.lock               # Locked dependency versions
├── docker-compose.yml          # Multi-container Docker setup
├── Dockerfile                  # PHP application image definition
├── Makefile                    # Shortcut commands (build, up, down, migrate)
├── README.md                   # Project documentation
└── symfony.lock                # Symfony recipe lock file
```

---

## 🐳 Docker Architecture
```
Browser
   ↓
Nginx (port 80)
   ↓
App (PHP / Symfony)
   ↓
MySQL (Library database)


```

**Key Points:**

- Only Nginx is exposed to the host machine
- The application and database communicate internally via Docker networking
- No local services are required
