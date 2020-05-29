<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$rootPath = __DIR__ . '/..';

$dotenv = Dotenv\Dotenv::createImmutable($rootPath);
$dotenv->load();

$app = AppFactory::create();

$app->addRoutingMiddleware();

require "{$rootPath}/bootstrap.php";

$app->run();
