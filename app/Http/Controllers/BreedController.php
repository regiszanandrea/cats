<?php

namespace App\Http\Controllers;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use App\Actions\Breeds\FindBreeds;

/**
 * @OA\Schema(
 *   schema="Breed",
 *   type="array",
 *   @OA\Items(
 *       type="object",
 *       @OA\Property(property="id", type="string"),
 *       @OA\Property(property="lap", type="integer"),
 *       @OA\Property(property="rex", type="integer"),
 *       @OA\Property(property="name", type="string"),
 *       @OA\Property(property="rare", type="integer"),
 *       @OA\Property(property="indoor", type="integer"),
 *       @OA\Property(property="origin", type="string"),
 *       @OA\Property(property="weight", type="object", 
 *           @OA\Property(property="metric", type="string"),
 *           @OA\Property(property="imperial", type="string"),
 *       ),
 *       @OA\Property(property="cfa_url", type="string"),
 *       @OA\Property(property="natural", type="integer"),
 *       @OA\Property(property="grooming", type="integer"),
 *       @OA\Property(property="hairless", type="integer"),
 *       @OA\Property(property="life_span", type="string"),
 *       @OA\Property(property="bidability", type="integer"),
 *       @OA\Property(property="short_legs", type="integer"),
 *       @OA\Property(property="description", type="string"),
 *       @OA\Property(property="temperament", type="string"),
 *       @OA\Property(property="adaptability", type="integer"),
 *       @OA\Property(property="cat_friendly", type="integer"),
 *       @OA\Property(property="country_code", type="string"),
 *       @OA\Property(property="dog_friendly", type="integer"),
 *       @OA\Property(property="energy_level", type="integer"),
 *       @OA\Property(property="experimental", type="integer"),
 *       @OA\Property(property="intelligence", type="integer"),
 *       @OA\Property(property="social_needs", type="integer"),
 *       @OA\Property(property="country_codes", type="string"),
 *       @OA\Property(property="vocalisation", type="integer"),
 *       @OA\Property(property="health_issues", type="integer"),
 *       @OA\Property(property="vetstreet_url", type="string"),
 *       @OA\Property(property="wikipedia_url", type="string"),
 *       @OA\Property(property="child_friendly", type="integer"),
 *       @OA\Property(property="hypoallergenic", type="integer"),
 *       @OA\Property(property="shedding_level", type="integer"),
 *       @OA\Property(property="affection_level", type="integer"),
 *       @OA\Property(property="suppressed_tail", type="integer"),
 *       @OA\Property(property="vcahospitals_url", type="string"),
 *       @OA\Property(property="stranger_friendly", type="integer"),
 *   )
 * )
 * 
 * Class BreedController
 * @package App\Http\Controllers
 */
class BreedController
{
    /**
     * @OA\Get(
     *     tags={"breeds"},
     *     summary="Returns a list of breeds",
     *     description="Returns a object of breeds",
     *     path="/api/breeds",
     *     @OA\Response(
     *         response="200", 
     *         description="A list with breeds",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/Breed"),
     *         )
     *     ),  
     *      
     *     @OA\Response(
     *         response="400",
     *         description="Bad request",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         ), 
     *      ),
     *     @OA\Response(
     *         response="500", 
     *         description="Internal server error",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         ),
     *    ),
     *),
     *

     *
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