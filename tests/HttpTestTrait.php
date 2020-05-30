<?php

namespace Tests;

use Psr\Http\Message\UriInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Factory\ServerRequestFactory;
use Psr\Http\Message\ServerRequestInterface;

trait HttpTestTrait
{
    /**
     * Create a server request.
     *
     * @param string $method The HTTP method
     * @param string|UriInterface $uri The URI
     * @param array $serverParams The server parameters
     *
     * @return ServerRequestInterface
     */
    protected function createRequest(string $method, $uri, array $serverParams = []): ServerRequestInterface
    {
        $factory = new ServerRequestFactory();

        return $factory->createServerRequest($method, $uri, $serverParams);
    }

    /**
     * Make request.
     *
     * @param ServerRequestInterface $request The request
     *
     * @return ResponseInterface
     */
    protected function request(ServerRequestInterface $request): ResponseInterface
    {
        return $this->getApp()->handle($request);
    }
}
