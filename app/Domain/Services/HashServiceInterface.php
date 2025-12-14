<?php

namespace App\Domain\Services;

/**
 * Hash Service Interface - For password/token hashing
 */
interface HashServiceInterface
{
    /**
     * Hash a value
     *
     * @param string $value
     * @return string
     */
    public function make(string $value): string;

    /**
     * Verify a value against a hash
     *
     * @param string $value
     * @param string $hashedValue
     * @return bool
     */
    public function check(string $value, string $hashedValue): bool;
}
