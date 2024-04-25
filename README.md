# NOS Backend Take-home Challenge

[![en](https://img.shields.io/badge/lang-en-green.svg)](https://github.com/pillowpilot/nos_blackend_challenge/blob/main/README.md)
[![es](https://img.shields.io/badge/lang-es-green.svg)](https://github.com/pillowpilot/nos_blackend_challenge/blob/main/README.es.md)

## Test locally

To test the project locally run:

```bash
docker compose up --build web
```

## Docker Compose Setup

The project setup consists on two services: `web` (the Laravel app with Apache2 as web server) and `db` (a MySQL db). The app is exposed on the port `8080` (`8080` is usually used for development purposes), so use [http://localhost:8080/api/boards](http://localhost:8080/api/boards). Notice the lack of final slash.

Migration should happend automatically on every run (just for demostration purposes).

```yaml
version: "3.2"

services:
    web:
        build: .
        depends_on:
            - db
        ports:
            - 8080:80
        entrypoint: sh -c "sleep 3 && php /var/www/html/artisan migrate --force && apache2-foreground"
    db:
        image: mysql
        ports:
            - "3306:3306" # Expose ports for manual inspection
        environment:
            - MYSQL_ROOT_PASSWORD=laravel1
```

## Automatic Testing

Run the API tests with `docker compose exec web bash` to enter into a terminal inside the container and run `php artisan test`.

## Manual Testing

Some testing results using Postman:

### Board creation

#### Request

Method: POST

URL: http://localhost:8080/api/boards

Body: `{
    "title": "New board"
}`

#### Response

Status: 201

Body: `{
    "stage": 1,
    "title": "New board",
    "id": 1
    }`

### Successful Board Update

#### Request

Method: PUT

URL: http://localhost:8080/api/boards/1

Body: `{
    "stage": "2"
}`

#### Response

Status: 200

Body: `{
 "id":1,
 "title":"New board",
 "stage":"2"
 }`

### Invalid Board Update

#### Request

Method: PUT

URL: http://localhost:8080/api/boards/1

Body: `{
    "stage": "23"
}`

#### Response

Status: 400

Body: `{
    "stage": [
        "The selected stage is invalid."
    ]
}`
