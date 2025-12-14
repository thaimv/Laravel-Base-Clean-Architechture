<?php

namespace App\Application\UseCases\Auth;

use App\Domain\Services\TokenServiceInterface;

class RefreshTokenUseCase
{
    public function __construct(
        protected TokenServiceInterface $tokenService,
    ) {
    }

    /**
     * Execute refresh token use case
     *
     * @return array
     */
    public function execute(): array
    {
        return [
            'access_token' => $this->tokenService->refresh(),
            'expires_in' => $this->tokenService->getExpirationTime(),
        ];
    }
}
