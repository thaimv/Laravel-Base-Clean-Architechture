<?php

namespace App\Application\UseCases\User;

use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;

class GetUserByIdUseCase
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
    ) {
    }

    /**
     * Execute get user by id use case
     *
     * @param int $id
     * @return User|null
     */
    public function execute(int $id): ?User
    {
        return $this->userRepository->findById($id);
    }
}
