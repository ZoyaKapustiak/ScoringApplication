# Docker для Symfony проекта

Готовая Docker-архитектура для Symfony на базе **PHP 8.4**, **MariaDB** и **Nginx**.

## Быстрый старт

### 1. Скопируйте .env.example в .env

```bash
cp .env.example .env
```

### 2. Запустите контейнеры

```bash
docker-compose up -d --build
```

### 3. Установка зависимостей
```bash
docker-compose exec php composer install
```

### 3. Создайте базу данных и выполните миграции

```bash
docker-compose exec php php bin/console doctrine:database:create --if-not-exists
```
```bash
docker-compose exec php php bin/console doctrine:migrations:migrate --all-or-nothing
```
```bash
docker-compose exec database mariadb -uroot -proot -e "CREATE DATABASE IF NOT EXISTS symfony_test; GRANT ALL PRIVILEGES ON symfony_test.* TO 'symfony'@'%'; FLUSH PRIVILEGES;"
```
```bash
docker-compose --env-file .env.test exec php bin/console doctrine:migrations:migrate --env=test --no-interaction --all-or-nothing
```
### 4. Создайте тестовые фикстуры и запустите тесты
```bash
docker-compose --env-file .env.test exec php bin/console doctrine:fixtures:load --env=test --no-interaction
```
```bash
docker compose --env-file .env.test exec php bin/phpunit
```
### 5. Создайте фикстуры 

```bash
docker-compose exec php bin/console doctrine:fixtures:load --no-interaction
```
### 6. Запустите команду для обновления скоринга всех клиентов
```bash
docker-compose exec php php bin/console scoring:calculate
```
### 7. Запустите команду для обновления скоринга всех клиентов с указанием ID
```bash
docker-compose exec php php bin/console scoring:calculate 15
```

## Доступ к сервисам

| Сервис       | URL                  | Порт  |
|--------------|----------------------|-------|
| Приложение   | http://localhost     | 80    |


## Полезные команды

#### Остановка контейнеров

```bash
docker-compose down
```
#### Просмотр логов
```bash
docker-compose logs -f
```
#### Вход в PHP контейнер
```bash
docker-compose exec php bash
```

#### Запуск phpMyAdmin (опционально) http://localhost:8080
```bash
docker-compose --profile tools up -d phpmyadmin
```
#### Очистка кэша
```bash
docker-compose exec php php bin/console cache:clear
```
#### Cs-Fixer
```bash
docker-compose exec php vendor/bin/php-cs-fixer fix /var/www/html
```


