<?php

namespace App\Application\UseCases\Auth;

use App\Domain\Services\TokenServiceInterface;

class LogoutUseCase
{
    public function __construct(
        protected TokenServiceInterface $tokenService,
    ) {
    }

    /**
     * Execute logout use case
     *
     * @return void
     */
    public function execute(): void
    {
        $this->tokenService->invalidate();
    }
}
