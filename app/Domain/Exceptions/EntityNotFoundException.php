<?php

namespace App\Domain\Exceptions;

use Exception;

/**
 * Domain Entity Not Found Exception - Pure PHP
 */
class EntityNotFoundException extends Exception
{
    public function __construct(string $message = 'Entity not found', int $code = 404)
    {
        parent::__construct($message, $code);
    }
}
