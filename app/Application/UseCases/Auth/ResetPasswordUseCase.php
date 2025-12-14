<?php

namespace App\Application\UseCases\Auth;

use App\Application\DTOs\Auth\ResetPasswordDTO;
use App\Domain\Exceptions\EntityNotFoundException;
use App\Domain\Repositories\PasswordResetTokenRepositoryInterface;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Services\HashServiceInterface;

class ResetPasswordUseCase
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected PasswordResetTokenRepositoryInterface $passwordResetTokenRepository,
        protected HashServiceInterface $hashService,
    ) {
    }

    /**
     * Execute reset password use case
     *
     * @param ResetPasswordDTO $dto
     * @return void
     * @throws EntityNotFoundException
     */
    public function execute(ResetPasswordDTO $dto): void
    {
        $user = $this->userRepository->findByField('email', $dto->email);

        if (!$user) {
            throw new EntityNotFoundException('User not found');
        }

        $this->userRepository->update(
            ['password' => $this->hashService->make($dto->password)],
            $user->id
        );

        $this->passwordResetTokenRepository->deleteByEmail($dto->email);
    }
}
