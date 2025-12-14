<?php

namespace App\Domain\Services;

/**
 * String Generator Interface - For generating random strings
 */
interface StringGeneratorInterface
{
    /**
     * Generate a random string
     *
     * @param int $length
     * @return string
     */
    public function random(int $length = 16): string;

    /**
     * Generate a UUID
     *
     * @return string
     */
    public function uuid(): string;
}
