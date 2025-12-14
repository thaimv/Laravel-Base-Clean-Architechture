<?php

namespace App\Application\UseCases\User;

use App\Application\DTOs\User\CreateUserDTO;
use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Services\HashServiceInterface;

class CreateUserUseCase
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected HashServiceInterface $hashService,
    ) {
    }

    /**
     * Execute create user use case
     *
     * @param CreateUserDTO $dto
     * @return User
     */
    public function execute(CreateUserDTO $dto): User
    {
        $data = $dto->toArray();
        $data['password'] = $this->hashService->make($data['password']);

        return $this->userRepository->create($data);
    }
}
