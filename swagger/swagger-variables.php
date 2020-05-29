<?php

require __DIR__ . '/../vendor/autoload.php';

$rootPath = __DIR__ . '/..';

$dotenv = Dotenv\Dotenv::createImmutable($rootPath);
$dotenv->load();

define('API_HOST', $_ENV['APP_URL']);