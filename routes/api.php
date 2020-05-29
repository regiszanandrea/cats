<?php

use Slim\Routing\RouteCollectorProxy;
use App\Http\Controllers\BreedController;

$app->group('/api', function (RouteCollectorProxy $group) {
    $group->get('/breeds', BreedController::class . ':index');
});
