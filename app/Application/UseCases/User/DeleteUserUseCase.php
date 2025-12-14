<?php

namespace App\Application\UseCases\User;

use App\Domain\Repositories\UserRepositoryInterface;

class DeleteUserUseCase
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
    ) {
    }

    /**
     * Execute delete user use case
     *
     * @param int $id
     * @return bool
     */
    public function execute(int $id): bool
    {
        return $this->userRepository->delete($id);
    }
}
