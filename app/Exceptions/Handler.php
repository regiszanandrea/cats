<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Database\QueryException;
use GuzzleHttp\Exception\ClientException;
use Slim\Interfaces\ErrorRendererInterface;

/**
 * Class Handler
 * @package App\Exceptions
 */
class Handler implements ErrorRendererInterface
{

    /**
     * @param Throwable $exception
     * @param bool $displayErrorDetails
     * @return string
     */
    public function __invoke(Throwable $exception, bool $displayErrorDetails): string
    {
        $code = $exception->getCode();

        switch ($code) {
            case 400:
                $message = 'Bad request';
                break;
            case 404:
                $message = 'Not found';
                break;
            default:
                $message = 'Internal Server Error';
                break;
        }

        if ($exception instanceof QueryException) {
            $message = 'Error trying to connect to database';
        }

        if ($exception instanceof ClientException) {
            $message = 'Error trying to connect too cats api';
        }

        return $message;
    }
}