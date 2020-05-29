<?php

use App\Http\Controllers\AuthController;

$app->post("/login", AuthController::class . ':login');
