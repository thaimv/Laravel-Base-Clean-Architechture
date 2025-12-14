<?php

namespace App\Application\UseCases\User;

use App\Application\DTOs\User\UpdateUserDTO;
use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Services\HashServiceInterface;

class UpdateUserUseCase
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected HashServiceInterface $hashService,
    ) {
    }

    /**
     * Execute update user use case
     *
     * @param int $id
     * @param UpdateUserDTO $dto
     * @return User
     */
    public function execute(int $id, UpdateUserDTO $dto): User
    {
        $data = $dto->toArray();

        if (isset($data['password'])) {
            $data['password'] = $this->hashService->make($data['password']);
        }

        return $this->userRepository->update($data, $id);
    }
}
