# Build all images
build:
	docker-compose build

# Start containers
up:
	docker-compose up -d

# Start containers and rebuild
up-build:
	docker-compose up -d --build

# Stop and remove containers
down:
	docker-compose down

# View running containers
ps:
	docker ps

# View logs
logs:
	docker-compose logs -f

# Enter the app container
app-shell:
	docker-compose exec app sh

# Enter the database container
db-shell:
	docker-compose exec database mysql -u root -p

# Create the database (if not exists)
db-create:
	docker compose exec app php bin/console doctrine:database:create --if-not-exists

# Run migrations
migrate:
	docker compose exec app php bin/console doctrine:migrations:migrate --no-interaction

# Generate a new migration
migration-diff:
	docker compose exec app php bin/console doctrine:migrations:diff

# Validate schema vs entities
schema-validate:
	docker compose exec app php bin/console doctrine:schema:validate

# Full reset (DANGEROUS – dev only)
db-reset:
	docker compose exec app php bin/console doctrine:database:drop --force
	docker compose exec app php bin/console doctrine:database:create
	docker compose exec app php bin/console doctrine:migrations:migrate --no-interaction


# Clean everything (containers, images, volumes)
clean:
	docker-compose down -v --rmi all
