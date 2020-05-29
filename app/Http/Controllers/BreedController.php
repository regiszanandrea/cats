<?php

namespace App\Http\Controllers;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use App\Actions\Breeds\FindBreeds;

/**
 * Class BreedController
 * @package App\Http\Controllers
 */
class BreedController
{
    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function index(Request $request, Response $response): Response
    {
        $params = $request->getQueryParams();
        $page = $params['page'] ?? 1;
        $limit = $params['limit'] ?? 10;
        $search = $params['name'] ?? null;

        $breeds = FindBreeds::find($page, $limit, $search);
        
        return $this->buildResponse($breeds, $response);
    }

    /**
     * @param array $data
     * @param Response $response
     * @return Response
     */
    private function buildResponse(array $data, Response $response): Response
    {
        $payload = json_encode($data);

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

}