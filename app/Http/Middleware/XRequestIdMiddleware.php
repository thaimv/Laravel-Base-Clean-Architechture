<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class XRequestIdMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $this->beforeRequest($request);
        $response = $next($request);
        $this->afterRequest($request, $response);

        return $response;
    }

    protected function beforeRequest(Request $request)
    {
        // Create X-Request-ID
        $requestId = Str::uuid();

        // Set X-Request-ID to request
        $request->headers->set('X-Request-ID', $requestId);

        // Start Logging
        Log::info("Start - URL: " . $request->fullUrl());
    }

    protected function afterRequest(Request $request, $response)
    {
        //// Add X-Request-ID to response header (if needed)
        //$response->headers->set('X-Request-ID', $request->header('X-Request-ID'));

        // End Logging
        Log::info("End - URL: " . $request->fullUrl() . " - Status code: " . $response->status());
    }
}
