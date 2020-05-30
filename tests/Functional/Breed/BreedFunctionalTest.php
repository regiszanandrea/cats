<?php


namespace Tests\Functional\Breed;


use Tests\BaseTestCase;
use App\Entities\Cache;
use Tests\HttpTestTrait;
use Tests\DatabaseTestTrait;

/**
 * @group BreedFunctional
 * Class BreedFunctionalTest
 * @package Tests\Functional\Breed
 */
class BreedFunctionalTest extends BaseTestCase
{
    use DatabaseTestTrait, HttpTestTrait;

    private $testToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1OTA4NDY3MTUsImV4cCI6MTkwNjM3OTUxNSwianRpIjoiM1lJVDh5dEVESUpOUnRxR1NYYms0cyIsInN1YiI6ImFkbWluIn0.eLGTnIjqfwUawnJCLmZbTuKVx2JpiGC2gDTX7R_QZo4';

    public function testShouldGetListOfBreeds(): void
    {
        $request = $this->createRequest('GET', '/api/breeds')
            ->withHeader('Authorization', "Bearer " . $this->testToken)
            ->withHeader('Accept', 'application/json');
        $response = $this->request($request);

        $this->assertSame(200, $response->getStatusCode());
    }

    public function testShouldGetExactTwentyBreeds(): void
    {
        $limit = 20;
        $request = $this->createRequest('GET', "/api/breeds?limit={$limit}")
            ->withHeader('Authorization', "Bearer " . $this->testToken)
            ->withHeader('Accept', 'application/json');
        $response = $this->request($request);

        $data = json_decode($response->getBody());
        $this->assertCount($limit, $data);
    }

    public function testShouldGetBreedsWithSearch(): void
    {
        $request = $this->createRequest('GET', "/api/breeds?name=sib")
            ->withHeader('Authorization', "Bearer " . $this->testToken)
            ->withHeader('Accept', 'application/json');
        $response = $this->request($request);

        $this->assertSame(200, $response->getStatusCode());
    }

    public function testShouldReturn401WithoutJWTToken(): void
    {
        $request = $this->createRequest('GET', '/api/breeds')
            ->withHeader('Accept', 'application/json');
        $response = $this->request($request);

        $this->assertSame(401, $response->getStatusCode());
    }

    public function testShouldSaveCache(): void
    {
        $request = $this->createRequest('GET', '/api/breeds')
            ->withHeader('Authorization', "Bearer " . $this->testToken)
            ->withHeader('Accept', 'application/json');
        $this->request($request);

        $cacheCount = Cache::count();

        $this->assertSame(1, $cacheCount);
    }

}