<?php

namespace App\Application\UseCases\Auth;

use App\Application\DTOs\Auth\LoginDTO;
use App\Domain\Exceptions\AuthenticationException;
use App\Domain\Services\TokenServiceInterface;

class LoginUseCase
{
    public function __construct(
        protected TokenServiceInterface $tokenService,
    ) {
    }

    /**
     * Execute login use case
     *
     * @param LoginDTO $dto
     * @return array
     * @throws AuthenticationException
     */
    public function execute(LoginDTO $dto): array
    {
        $token = $this->tokenService->attempt($dto->toArray());

        if (!$token) {
            throw new AuthenticationException(__('validation.auth_incorrect'));
        }

        return [
            'access_token' => $token,
            'expires_in' => $this->tokenService->getExpirationTime(),
        ];
    }
}
