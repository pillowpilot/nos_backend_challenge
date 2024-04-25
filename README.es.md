# Desafio NOS Backend

[![en](https://img.shields.io/badge/lang-en-green.svg)](https://github.com/pillowpilot/nos_blackend_challenge/blob/main/README.md)
[![es](https://img.shields.io/badge/lang-es-green.svg)](https://github.com/pillowpilot/nos_blackend_challenge/blob/main/README.es.md)

## Probar localmente

Para probar el projecto localmente ejecutar:

```bash
docker compose up --build web
```

## Docker Compose

Este proyecto consiste en dos servicios: `web` (la applicación Laravel con Apache2 como Web Server) y `db` (una DB MySQL). La aplicación expone el puerto `8080` (`8080` se suele utilizar para propositos de desarrollo), entonces utilize [http://localhost:8080/api/boards](http://localhost:8080/api/boards). Notar la falta de un `/` final.

La migración debería ocurrir automaticamente durante cada ejecución (por motivos demostrativos).

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
            - "3306:3306" # Exponer puertos para inspección manual
        environment:
            - MYSQL_ROOT_PASSWORD=laravel1
```

## Testing Automático

Ejecute los test API con `docker compose exec web bash` para entrar a una terminal dentro del contenedor y ejecute `php artisan test`.

## Testing Manual

Algunos resultados de testing con Postman:

### Creación de una Tabla

#### Consulta

Método: POST

URL: http://localhost:8080/api/boards

Cuerpo: `{
    "title": "New board"
}`

#### Respuesta

Codigo de Estado: 201

Cuerpo: `{
    "stage": 1,
    "title": "New board",
    "id": 1
    }`

### Successful Board Update

#### Consulta

Método: PUT

URL: http://localhost:8080/api/boards/1

Cuerpo: `{
    "stage": "2"
}`

#### Respuesta

Codigo de Estado: 200

Cuerpo: `{
 "id":1,
 "title":"New board",
 "stage":"2"
 }`

### Invalid Board Update

#### Consulta

Método: PUT

URL: http://localhost:8080/api/boards/1

Cuerpo: `{
    "stage": "23"
}`

#### Respuesta

Codigo de Estado: 400

Cuerpo: `{
    "stage": [
        "The selected stage is invalid."
    ]
}`
