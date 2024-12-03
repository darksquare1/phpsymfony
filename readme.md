## Docker

Create .env.local file which looks like this:
```
DATABASE_USER=changeme
DATABASE_PASSWORD=changeme
DATABASE_DB=changeme
DATABASE_URL="postgresql://${DATABASE_USER}:${DATABASE_PASSWORD}@postgres:5432/${DATABASE_DB}?serverVersion=16&charset=utf8"
```
Run the following commands:
```
docker-compose build --no-cache
docker compose up -d
docker compose exec php bash
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
```
Then you can go to http://localhost:8080/ to see the main page
