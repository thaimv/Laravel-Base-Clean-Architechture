<?php

namespace App\Domain\Exceptions;

use Exception;

/**
 * Domain Authentication Exception - Pure PHP
 */
class AuthenticationException extends Exception
{
    public function __construct(string $message = 'Authentication failed', int $code = 401)
    {
        parent::__construct($message, $code);
    }
}
