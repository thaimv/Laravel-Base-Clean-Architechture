<?php

namespace App\Infrastructure\Logging\Processor;

use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Request;
use Monolog\LogRecord;

class XRequestIdProcessor
{
    public function __invoke(Logger $logger)
    {
        // Add X-Request-ID to Request Headers
        foreach ($logger->getHandlers() as $handler) {
            $handler->pushProcessor(function (LogRecord $record): LogRecord {
                return $record->with(extra: array_merge($record->extra, [
                    'x_request_id' => Request::header('X-Request-ID', null),
                ]));
            });
        }
    }
}
