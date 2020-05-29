# Cats

- [Installation](#installation)
- [Running](#running)
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

Add CAT_API_KEY to your .env 
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

<a name="testing" />

## Testing
Just run:
```bash
phpunit
```


<a name="license" />

## License

Cats is an open-sourced software licensed under the [MIT license](license.md)
