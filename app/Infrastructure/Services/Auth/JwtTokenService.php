<?php

namespace App\Infrastructure\Services\Auth;

use App\Domain\Services\TokenServiceInterface;
use Illuminate\Support\Facades\Auth;

/**
 * JWT Token Service - Infrastructure implementation
 */
class JwtTokenService implements TokenServiceInterface
{
    /**
     * Attempt to authenticate with credentials
     *
     * @param array $credentials
     * @return string|null
     */
    public function attempt(array $credentials): ?string
    {
        $token = Auth::attempt($credentials);

        return $token ?: null;
    }

    /**
     * Refresh the current token
     *
     * @return string
     */
    public function refresh(): string
    {
        return Auth::refresh();
    }

    /**
     * Invalidate the current token (logout)
     *
     * @return void
     */
    public function invalidate(): void
    {
        Auth::logout();
    }

    /**
     * Get token expiration time in seconds
     *
     * @return int
     */
    public function getExpirationTime(): int
    {
        return Auth::factory()->getTTL() * 60;
    }
}
