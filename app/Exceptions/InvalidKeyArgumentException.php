<?php

namespace App\Exceptions;

use Exception;
use Psr\SimpleCache\InvalidArgumentException;

class InvalidKeyArgumentException extends Exception implements InvalidArgumentException
{

}