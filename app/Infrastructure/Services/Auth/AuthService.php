<?php

namespace App\Infrastructure\Services\Auth;

use App\Application\UseCases\Auth\ForgotPasswordUseCase;
use App\Application\UseCases\Auth\LoginUseCase;
use App\Application\UseCases\Auth\LogoutUseCase;
use App\Application\UseCases\Auth\RefreshTokenUseCase;
use App\Application\UseCases\Auth\ResetPasswordUseCase;
use App\Application\DTOs\Auth\LoginDTO;
use App\Application\DTOs\Auth\ResetPasswordDTO;
use App\Domain\Services\AuthServiceInterface;

class AuthService implements AuthServiceInterface
{
    public function __construct(
        protected LoginUseCase $loginUseCase,
        protected LogoutUseCase $logoutUseCase,
        protected RefreshTokenUseCase $refreshTokenUseCase,
        protected ForgotPasswordUseCase $forgotPasswordUseCase,
        protected ResetPasswordUseCase $resetPasswordUseCase,
    ) {
    }

    /**
     * Authenticate user and generate token
     *
     * @param array $credentials
     * @return array
     */
    public function login(array $credentials): array
    {
        return $this->loginUseCase->execute(LoginDTO::fromArray($credentials));
    }

    /**
     * Refresh the current token
     *
     * @return array
     */
    public function refreshToken(): array
    {
        return $this->refreshTokenUseCase->execute();
    }

    /**
     * Logout the current user
     *
     * @return void
     */
    public function logout(): void
    {
        $this->logoutUseCase->execute();
    }

    /**
     * Send password reset email
     *
     * @param string $email
     * @return void
     */
    public function forgotPassword(string $email): void
    {
        $this->forgotPasswordUseCase->execute($email);
    }

    /**
     * Reset user password
     *
     * @param array $params
     * @return void
     */
    public function resetPassword(array $params): void
    {
        $this->resetPasswordUseCase->execute(ResetPasswordDTO::fromArray($params));
    }
}
