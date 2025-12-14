<?php

namespace App\Infrastructure\Providers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Response as ResponseStatus;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Response::macro('success', function ($data = [], $message = 'success', $status = ResponseStatus::HTTP_OK) {
            if (isset($data->resource) && $data->resource instanceof LengthAwarePaginator) {
                $data = [
                    'items' => $data->resource->items(),
                    'meta' => [
                        'total' => $data->resource->total(),
                        'per_page' => $data->resource->perPage(),
                        'next_page' => $data->resource->nextPageUrl(),
                        'prev_page' => $data->resource->previousPageUrl(),
                        'current_page' => $data->resource->currentPage(),
                    ],
                ];
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $data,
            ], $status);
        });

        Response::macro('error', function ($message = 'error', $status = ResponseStatus::HTTP_NOT_FOUND, $errors = []) {
            return response()->json([
                'success' => false,
                'message' => $message,
                'errors' => $errors,
            ], $status);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
