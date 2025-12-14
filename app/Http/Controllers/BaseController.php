<?php

namespace App\Http\Controllers;

use App\Http\Exceptions\ExceptionHandler;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as ResponseStatus;
use Exception;

class BaseController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Handle various exceptions
     *
     * @param Exception $e
     * @return ResponseFactory|Application|JsonResponse|RedirectResponse|\Illuminate\Http\Response|object
     */
    protected function handleException(Exception $e)
    {
        return ExceptionHandler::handle($e);
    }

    protected function responseSuccess($data = [], $message = 'success', $status = ResponseStatus::HTTP_OK)
    {
        return Response::success($data, $message, $status);
    }

    protected function responseError($message = 'error', $status = ResponseStatus::HTTP_NOT_FOUND, $errors = [])
    {
        return Response::error($message, $status, $errors);
    }
}
