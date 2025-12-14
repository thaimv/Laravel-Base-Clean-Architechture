<?php

namespace App\Http\Exceptions;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseStatus;
use Throwable;

class ExceptionHandler
{
    public static function handle(Throwable $e)
    {
        Log::error("Error", [
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]);

        $customErrors = [
            \Illuminate\Database\Eloquent\ModelNotFoundException::class => [
                __('exception.404'), ResponseStatus::HTTP_NOT_FOUND, []
            ],
            \Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class => [
                __('exception.404_route'), ResponseStatus::HTTP_NOT_FOUND, []
            ],
            \Illuminate\Validation\ValidationException::class => [
                __('exception.422'),
                ResponseStatus::HTTP_UNPROCESSABLE_ENTITY,
                $e instanceof ValidationException ? $e->errors() : []
            ],
            \Illuminate\Auth\Access\AuthorizationException::class => [
                __('exception.403'), ResponseStatus::HTTP_FORBIDDEN, []
            ],
            \Illuminate\Auth\AuthenticationException::class => [
                __('exception.401'), ResponseStatus::HTTP_UNAUTHORIZED, []
            ],
            \Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException::class => [
                __('exception.503'), ResponseStatus::HTTP_SERVICE_UNAVAILABLE, []
            ]
        ];

        $request = request();

        foreach ($customErrors as $class => [$message, $status, $errors]) {
            if ($e instanceof $class) {
                return $request->expectsJson()
                    ? response()->json(['success' => false, 'message' => $message, 'errors' => $errors], $status)
                    : response(view("errors.$status"), $status);
            }
        }

        // Validate HTTP status code (must be between 100-599)
        $exceptionCode = $e->getCode();
        $statusCode = ($exceptionCode >= 100 && $exceptionCode <= 599)
            ? $exceptionCode
            : ResponseStatus::HTTP_INTERNAL_SERVER_ERROR;

        $messageKey = "exception.{$statusCode}";
        $message = __($messageKey);
        $errors = config('app.debug') ? $e->getMessage() : '';

        return $request->expectsJson()
            ? Response::error($message, $statusCode, $errors)
            : ($statusCode === ResponseStatus::HTTP_UNPROCESSABLE_ENTITY
                ? back()->withErrors($errors)->withInput()
                : response(
                    view()->exists("errors.$statusCode") ? view("errors.$statusCode") : view("errors.500"),
                    $statusCode
                )
            );
    }
}
