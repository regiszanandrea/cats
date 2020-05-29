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

// Add Whoops Tool
if ((bool)($_ENV['DEBUG'] ?? false)) {
    $app->add(new Zeuxisoo\Whoops\Slim\WhoopsMiddleware(['enable' => true]));
} else {
    // Add Error Middleware
    $errorMiddleware = $app->addErrorMiddleware(false, true, true);

    // Get the default error handler and register my custom error renderer.
    $errorHandler = $errorMiddleware->getDefaultErrorHandler();
    $errorHandler->forceContentType('application/json');
    $errorHandler->registerErrorRenderer('application/json', Handler::class);
}




