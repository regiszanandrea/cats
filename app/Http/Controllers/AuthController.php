<?php


namespace App\Http\Controllers;


use Tuupola\Base62;
use Firebase\JWT\JWT;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

/**
 * Class AuthController
 * @package App\Http\Controllers
 */
class AuthController
{

    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
     * @throws \Exception
     */
    public function login(Request $request, Response $response)
    {
        $now = new \DateTime();
        $future = new \DateTime('now +2 hours');
        $server = $request->getServerParams();

        $jti = (new Base62)->encode(random_bytes(16));

        $payload = [
            'iat' => $now->getTimeStamp(),
            'exp' => $future->getTimeStamp(),
            'jti' => $jti,
            'sub' => $server['PHP_AUTH_USER'],
        ];

        $secret = $_ENV['JWT_SECRET'];
        $token = JWT::encode($payload, $secret);

        $data['token'] = $token;
        $data['expires'] = $future->getTimeStamp();

        $response->getBody()->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        return $response->withStatus(201)
            ->withHeader('Content-Type', 'application/json');
    }
}