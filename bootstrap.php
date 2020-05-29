<?php

use App\Exceptions\Handler;
use Illuminate\Database\Capsule\Manager;

$root = __DIR__;

$catApi = include("{$root}/config/cat-api.php");
$app->catApi = $catApi;

$database = include("{$root}/config/database.php");

$capsule = new Manager;
$capsule->addConnection($database['mysql']);

$capsule->setAsGlobal();
$capsule->bootEloquent();

$container = $app->getContainer();
$container['db'] = function ($container) use ($capsule) {
    return $capsule;
};

require "{$root}/routes/web.php";
require "{$root}/routes/auth.php";


// Add Whoops Tool
if ($_ENV['DEBUG'] == 'true') {
    $app->add(new Zeuxisoo\Whoops\Slim\WhoopsMiddleware(['enable' => true]));
} else {
    // Add Error Middleware
    $errorMiddleware = $app->addErrorMiddleware(false, true, true);

    // Get the default error handler and register my custom error renderer.
    $errorHandler = $errorMiddleware->getDefaultErrorHandler();
    $errorHandler->forceContentType('application/json');
    $errorHandler->registerErrorRenderer('application/json', Handler::class);
}

$app->add(new Tuupola\Middleware\HttpBasicAuthentication([
    "path" => "/login",
    "relaxed" => ["127.0.0.1", "localhost"],
    "secure" => false,
    "users" => [
        "admin" => '@#$RF@!718',
    ]
]));

$app->add(new Tuupola\Middleware\JwtAuthentication([
    "secure" => false,
    'path' => '/api',
    'relaxed' => ['127.0.0.1', 'localhost'],
    'secret' =>  $_ENV['JWT_SECRET']
]));


