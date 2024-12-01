php src/cli.php --migrate

php src/cli.php --generate-entities

docker compose exec app php /var/www/html/src/cli.php --migrate
php -S localhost:8000 -t public
