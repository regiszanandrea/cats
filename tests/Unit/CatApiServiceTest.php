<?php


namespace Tests\Unit;


use Tests\BaseTestCase;
use Tests\DatabaseTestTrait;
use App\Services\CatApiService;

/**
 * @group CatApiService
 *
 * Class CatApiServiceTest
 * @package Tests\Unit
 */
class CatApiServiceTest extends BaseTestCase
{
    use DatabaseTestTrait;

    public function testShouldGetBreeds(): void
    {
        $page = 1;
        $limit = 10;
        $response = CatApiService::breeds($page, $limit);

        $this->assertIsArray($response);
    }

    public function testShouldGetBreedsWithSearch(): void
    {
        $page = 1;
        $limit = 10;
        $search = 'sib';
        $response = CatApiService::breeds($page, $limit, $search);

        $this->assertIsArray($response);
    }

    public function testShouldGetExactTwentyBreeds(): void
    {
        $page = 1;
        $limit = 20;
        $response = CatApiService::breeds($page, $limit);

        $this->assertCount($limit, $response);
    }

    public function testShouldExpectEmptyArray(): void
    {
        $page = 1;
        $limit = 20;
        $search = substr(str_shuffle(MD5(microtime())), 0, 255);
        $response = CatApiService::breeds($page, $limit, $search);

        $this->assertEquals([], $response);
    }
}