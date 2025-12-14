<?php

namespace App\Infrastructure\Services\Common;

use App\Domain\Services\HashServiceInterface;
use Illuminate\Support\Facades\Hash;

/**
 * Laravel Hash Service Implementation
 */
class LaravelHashService implements HashServiceInterface
{
    /**
     * Hash a value
     *
     * @param string $value
     * @return string
     */
    public function make(string $value): string
    {
        return Hash::make($value);
    }

    /**
     * Verify a value against a hash
     *
     * @param string $value
     * @param string $hashedValue
     * @return bool
     */
    public function check(string $value, string $hashedValue): bool
    {
        return Hash::check($value, $hashedValue);
    }
}
