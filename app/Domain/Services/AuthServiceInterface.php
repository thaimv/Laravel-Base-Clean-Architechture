<?php

namespace App\Domain\Services;

interface AuthServiceInterface
{
    /**
     * Authenticate user and generate token
     *
     * @param array $credentials
     * @return array
     */
    public function login(array $credentials): array;

    /**
     * Refresh the current token
     *
     * @return array
     */
    public function refreshToken(): array;

    /**
     * Logout the current user
     *
     * @return void
     */
    public function logout(): void;

    /**
     * Send password reset email
     *
     * @param string $email
     * @return void
     */
    public function forgotPassword(string $email): void;

    /**
     * Reset user password
     *
     * @param array $params
     * @return void
     */
    public function resetPassword(array $params): void;
}
