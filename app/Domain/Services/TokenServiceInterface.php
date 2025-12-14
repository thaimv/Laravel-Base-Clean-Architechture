<?php

namespace App\Domain\Services;

/**
 * Token Service Interface - For JWT/Auth token operations
 */
interface TokenServiceInterface
{
    /**
     * Attempt to authenticate with credentials
     *
     * @param array $credentials
     * @return string|null Token if successful, null if failed
     */
    public function attempt(array $credentials): ?string;

    /**
     * Refresh the current token
     *
     * @return string
     */
    public function refresh(): string;

    /**
     * Invalidate the current token (logout)
     *
     * @return void
     */
    public function invalidate(): void;

    /**
     * Get token expiration time in seconds
     *
     * @return int
     */
    public function getExpirationTime(): int;
}
