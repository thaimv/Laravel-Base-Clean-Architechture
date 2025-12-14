<?php

namespace App\Infrastructure\Services\User;

use App\Application\DTOs\User\CreateUserDTO;
use App\Application\DTOs\User\ListUserDTO;
use App\Application\DTOs\User\UpdateUserDTO;
use App\Application\UseCases\User\CreateUserUseCase;
use App\Application\UseCases\User\DeleteUserUseCase;
use App\Application\UseCases\User\GetUserByIdUseCase;
use App\Application\UseCases\User\GetUserListUseCase;
use App\Application\UseCases\User\UpdateUserUseCase;
use App\Domain\Services\UserServiceInterface;

class UserService implements UserServiceInterface
{
    public function __construct(
        protected GetUserListUseCase $getUserListUseCase,
        protected GetUserByIdUseCase $getUserByIdUseCase,
        protected CreateUserUseCase $createUserUseCase,
        protected UpdateUserUseCase $updateUserUseCase,
        protected DeleteUserUseCase $deleteUserUseCase,
    ) {
    }

    /**
     * Get paginated list of users
     *
     * @param array $params
     * @return mixed
     */
    public function list(array $params): mixed
    {
        return $this->getUserListUseCase->execute(ListUserDTO::fromArray($params));
    }

    /**
     * Get user by ID
     *
     * @param int $id
     * @return mixed
     */
    public function findById(int $id): mixed
    {
        return $this->getUserByIdUseCase->execute($id);
    }

    /**
     * Create a new user
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data): mixed
    {
        return $this->createUserUseCase->execute(CreateUserDTO::fromArray($data));
    }

    /**
     * Update user
     *
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data): mixed
    {
        return $this->updateUserUseCase->execute($id, UpdateUserDTO::fromArray($data));
    }

    /**
     * Delete user
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->deleteUserUseCase->execute($id);
    }
}
