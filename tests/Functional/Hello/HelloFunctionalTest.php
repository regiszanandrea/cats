<?php

namespace Tests\Functional\Hello;

use Tests\BaseTestCase;
use Tests\HttpTestTrait;

/**
 * @group Hello
 * Class HelloFunctionalTest
 * @package Tests\Functional\Hello
 */
class HelloFunctionalTest extends BaseTestCase
{
    use HttpTestTrait;


    public function testHelloEndpoint(): void
    {
        $request = $this->createRequest('GET', '/');
        $response = $this->request($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertStringContainsString('This is a Cats API from thecatapi.com', (string)$response->getBody());
    }
}