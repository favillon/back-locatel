<p align="center">
    <a href="https://favillon.site" target="_blank">
        <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
    </a>
</p>
<p align="center">
    <a href="https://www.locatelcolombia.com/" target="_blank">
        <img src="https://locatelcolombia.vtexassets.com/assets/vtex.file-manager-graphql/images/d24047f6-548e-44f2-9ef6-d0e6e48229f9___1bc6e809f887b47ea360ee4ade95fbcc.png"  alt="Locatel Logo">
    </a>
</p>

## Creacion de los Modelos Factories Migraciones y Seed

Comando creacion Modelos Migraciones y Factories

```shell
./vendor/bin/sail php artisan make:model AccountType -mf 
./vendor/bin/sail php artisan make:model TransactionType -mf 
./vendor/bin/sail php artisan make:model Account -mf 
./vendor/bin/sail php artisan make:model Transaction -mf 
```

Corriendo las migracion y los factories

```shell
./vendor/bin/sail php artisan migrate --seed
```

Instalando dependencia del UUID

```shell
./vendor/bin/sail composer require ramsey/uuid
```

Creando Controlador para Transacciones

```
./vendor/bin/sail php artisan make:controller Api/TransactionController
```




# Proyecto base para creacion de API con Laravel
***

Proyecto base para creacion de API con Laravel (imagenes, accestoken, test)
- Tener instalador con Docker.
- Tener docker-compose

Este proyecto tiene  `psql` y `redis` como base

Para levantar el entorno solo debe hacer pull al repositorio y posterior  acceder y levantar sail 

```shell
git clone git@github.com:favillon/api_laravel.git
cd api-laravel/ && ./vendor/bin/sail up
```

## Acceso a la aplicacion 

Url de acceso principal
```
localhost
```

## URL 
Url de navegacion basica

```
POST localhost/api/register
POST localhost/api/login
GET localhost/api/profile
DELETE localhost/api/logout
```

Existe una coleccion en postman para si vinculacion y testeo 
> ./readme/DevApiLaravel.postman_collection.json

![Test](./readme/img/postman.png)

## Ejecucion de pruebas

Para ejecutar las pruebas 
```shell
./vendor/bin/sail php artisan  test
```
Resultado
![Test](./readme/img/test.png)



### Creacion del proyecto

Se crea usando sails y las configuraciones basicas BD, y manejo de cache

```shell
curl -s "https://laravel.build/technical-test-fabian-villon?with=pgsql,redis" | bash
```