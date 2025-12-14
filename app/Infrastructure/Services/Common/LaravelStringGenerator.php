<?php

namespace App\Infrastructure\Services\Common;

use App\Domain\Services\StringGeneratorInterface;
use Illuminate\Support\Str;

/**
 * Laravel String Generator Implementation
 */
class LaravelStringGenerator implements StringGeneratorInterface
{
    /**
     * Generate a random string
     *
     * @param int $length
     * @return string
     */
    public function random(int $length = 16): string
    {
        return Str::random($length);
    }

    /**
     * Generate a UUID
     *
     * @return string
     */
    public function uuid(): string
    {
        return Str::uuid()->toString();
    }
}
