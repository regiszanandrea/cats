<?php


namespace App\Services;

use App\Util\ApiRequest;
use App\Util\DatabaseCache;
use App\Exceptions\InvalidKeyArgumentException;


/**
 * Class CatApiService
 * @package App\Services
 */
class CatApiService
{
    /**
     * @param $page
     * @param $limit
     * @param null $search
     * @return array|mixed
     */
    public static function breeds($page, $limit, $search = null)
    {
        $cache = new DatabaseCache();

        $key = "breeds:{$page}:{$limit}:{$search}";

        // Get from cache or make call to API
        try {
            return $cache->remember($key, function () use ($page, $limit, $search) {
                $endpoint = 'breeds';

                if ($search) {
                    $endpoint = 'breeds/search';
                }

                $apiRequest = self::getApiInstance();
                $authenticationHeader = $apiRequest->catApi['authentication_header'];
                $key = $apiRequest->catApi['key'];

                $parameters = [
                    'page' => $page,
                    'limit' => $limit,
                ];

                if ($search) {
                    $parameters['q'] = $search;
                }

                $response = $apiRequest->get($endpoint, $parameters, $authenticationHeader, $key);

                if ($response->getStatusCode() === 200) {
                    return self::getBody($response);
                }
                return [];
            });
        } catch (InvalidKeyArgumentException $e) {
            // TODO: log
            return [];
        }
    }

    /**
     * @return ApiRequest
     */
    private static function getApiInstance(): ApiRequest
    {
        $catApi = include(__DIR__ . '/../../config/cat-api.php');

        $apiRequest = new ApiRequest($catApi['base_url']);

        $apiRequest->catApi = $catApi;
        return $apiRequest;
    }

    /**
     * @param $response
     * @return mixed
     */
    private static function getBody($response)
    {
        return json_decode($response->getBody()->getContents());
    }
}