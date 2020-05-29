<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write('Hello world! This is a Cats API from thecatapi.com');
    return $response;
});

$app->get('/health', function (Request $request, Response $response, $args) {
    $response->getBody()->write('OK');
    return $response;
});