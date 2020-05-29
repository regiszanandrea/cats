<?php


namespace App\Util;


use Exception;
use GuzzleHttp\Client;

class ApiRequest
{

    private $client;

    /**
     * ApiRequest constructor.
     * @param $baseUrl
     */
    public function __construct($baseUrl)
    {
        $this->client = new Client([
            'base_uri' => $baseUrl,
            'timeout' => 2.0,
        ]);
    }

    /**
     * @param string $endpoint
     * @param array $parameters
     * @param null $authenticationHeader
     * @param null $key
     * @return mixed
     * @throws Exception
     */
    public function get(string $endpoint, array $parameters, $authenticationHeader = null, $key = null)
    {
        if ($key) {
            return $this->client->get($endpoint, [
                'query' => $parameters,
                'headers' => [
                    'Accept' => 'application/json',
                    $authenticationHeader => $key
                ]
            ]);
        }
        return $this->client->get($endpoint, [
            'query' => $parameters
        ]);
    }

}