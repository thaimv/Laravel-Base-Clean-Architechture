<?php

namespace App\Http\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Exception;

class CustomException extends Exception
{
    public function __construct($message = '', $code = null)
    {
        if (!$message) {
            $message = trans('exception.422');
        }

        if (!$code) {
            $code = Response::HTTP_UNPROCESSABLE_ENTITY;
        }
        parent::__construct($message, $code);
    }
}
