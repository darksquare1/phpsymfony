## Docker


Make sure you are in the /docker directory
```
docker-compose build --no-cache
docker compose up -d
docker compose exec php bash
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
```
Then you can go to http://localhost:8080/ to see the main page
