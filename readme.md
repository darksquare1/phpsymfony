## Docker



```
docker-compose build --no-cache
docker compose up -d
docker compose exec php bash
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
