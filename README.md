# Cats

- [Installation](#installation)
- [Running](#running)
- [Documentation](#documentation)
- [Testing](#testing)
- [License](#license)

<a name="installation" />

## Installation
> **Requires [PHP 7.2+](https://php.net/releases/)**


Install dependencies
```bash
composer install
```

Generates .env 
```bash
cp .env.example .env
```

Add CAT_API_KEY, APP_URL, APP_KEY, JWT_SECRET and DB_DRIVER to your .env 
```bash
nano .env
```

##### Configures your database access and Generate the tables 
```bash
php vendor/bin/phinx migrate -c config-phinx.php
```

<a name="running" />

## Running
Run the server:
```bash
php -S localhost:8080 -t public public/index.php
```

And you are good to go :)

<a name="documentation" />

## Documentation
The documentation was build with swagger. So, to run swagger, you will need docker and execute:
```bash
docker run -d -p 8080:8080 -e SWAGGER_JSON=/openapi.yaml -v h<absolute pat>/public/swagger/openapi.yaml:/openapi.yaml swaggerapi/swagger-ui
```
<a name="testing" />

## Testing
Just run:
```bash
phpunit --configuration phpunit.xml
```


<a name="license" />

## License

Cats is an open-sourced software licensed under the [MIT license](license.md)
