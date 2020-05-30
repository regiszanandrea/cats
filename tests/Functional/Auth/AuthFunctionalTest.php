<?php


namespace Tests\Functional\Auth;


use Tests\BaseTestCase;
use Tests\HttpTestTrait;
use Slim\Psr7\Factory\ResponseFactory;
use Psr\Http\Message\ResponseInterface;
use Tuupola\Middleware\JwtAuthentication;
use Psr\Http\Message\ServerRequestInterface;
use Tuupola\Middleware\HttpBasicAuthentication;

/**
 * @group Auth
 * Class AuthFunctionalTest
 * @package Tests\Functional\Auth
 */
class AuthFunctionalTest extends BaseTestCase
{
    use HttpTestTrait;

    private $testToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1OTA4NDY3MTUsImV4cCI6MTkwNjM3OTUxNSwianRpIjoiM1lJVDh5dEVESUpOUnRxR1NYYms0cyIsInN1YiI6ImFkbWluIn0.eLGTnIjqfwUawnJCLmZbTuKVx2JpiGC2gDTX7R_QZo4';

    public function testShouldReturn200WithoutPassword(): void
    {
        $request = $this->createRequest('GET', '/');
        $response = (new ResponseFactory())->createResponse();

        $auth = new HttpBasicAuthentication([
            "path" => "/login",
            "secure" => false,
            "realm" => "Protected",
            "users" => [
                "admin" => '@#$RF@!718',
            ]
        ]);

        $next = function (ServerRequestInterface $request, ResponseInterface $response) {
            $response->getBody()->write("Success");
            return $response;
        };

        $response = $auth($request, $response, $next);

        $this->assertSame(200, $response->getStatusCode());
    }

    public function testShouldReturn200WithPassword(): void
    {
        $login = base64_encode('admin:@#$RF@!718');

        $request = $this->createRequest('POST', '/login')
            ->withHeader('Authorization', "Basic {$login}");
        $response = (new ResponseFactory())->createResponse();

        $auth = new HttpBasicAuthentication([
            "path" => "/login",
            "secure" => false,
            "realm" => "Protected",
            "users" => [
                "admin" => '@#$RF@!718',
            ]
        ]);

        $next = function (ServerRequestInterface $request, ResponseInterface $response) {
            $response->getBody()->write("Success");
            return $response;
        };

        $response = $auth($request, $response, $next);

        $this->assertSame(200, $response->getStatusCode());
    }

    public function testShouldReturn401WithoutPassword(): void
    {
        $request = $this->createRequest('POST', '/login');
        $response = (new ResponseFactory)->createResponse();

        $auth = new HttpBasicAuthentication([
            "path" => "/login",
            "secure" => false,
            "realm" => "Protected",
            "users" => [
                "admin" => '@#$RF@!718',
            ]
        ]);

        $next = function (ServerRequestInterface $request, ResponseInterface $response) {
            $response->getBody()->write("Success");
            return $response;
        };

        $response = $auth($request, $response, $next);

        $this->assertEquals(401, $response->getStatusCode());
        $this->assertEquals('Basic realm="Protected"', $response->getHeaderline("WWW-Authenticate"));
        $this->assertEquals("", $response->getBody());
    }

    public function testShouldReturn200WithJWTToken(): void
    {
        $request = $this->createRequest('GET', '/api/breeds')
            ->withHeader('Authorization', "Bearer " . $this->testToken);
        $response = (new ResponseFactory)->createResponse();

        $default = function (ServerRequestInterface $request) {
            $response = (new ResponseFactory)->createResponse();
            $response->getBody()->write("Success");
            return $response;
        };

        $auth = new JwtAuthentication([
                'secure' => false,
                'path' => '/api',
                'relaxed' => ['127.0.0.1', 'localhost'],
                'secret' => $_ENV['JWT_SECRET']
            ]);

        $response = $auth($request, $response, $default);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("Success", $response->getBody());
    }

    public function testShouldReturn401WithoutJWTToken(): void
    {
        $request = $this->createRequest('GET', '/api/breeds');
        $response = (new ResponseFactory)->createResponse();

        $default = function (ServerRequestInterface $request) {
            $response = (new ResponseFactory)->createResponse();
            $response->getBody()->write("Success");
            return $response;
        };

        $auth = new JwtAuthentication([
            'secure' => false,
            'path' => '/api',
            'relaxed' => ['127.0.0.1', 'localhost'],
            'secret' => $_ENV['JWT_SECRET']
        ]);

        $response = $auth($request, $response, $default);

        $this->assertEquals(401, $response->getStatusCode());
    }
}