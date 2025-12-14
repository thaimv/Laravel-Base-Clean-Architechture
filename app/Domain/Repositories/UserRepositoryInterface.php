<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\User;
use App\Domain\ValueObjects\PaginatedResult;

interface UserRepositoryInterface
{
    /**
     * Get paginated list of users
     *
     * @param array $params
     * @return PaginatedResult
     */
    public function list(array $params): PaginatedResult;

    /**
     * Find user by field
     *
     * @param string $field
     * @param mixed $value
     * @return User|null
     */
    public function findByField(string $field, mixed $value): ?User;

    /**
     * Find user by ID
     *
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?User;

    /**
     * Create a new user
     *
     * @param array $data
     * @return User
     */
    public function create(array $data): User;

    /**
     * Update user by ID
     *
     * @param array $data
     * @param int $id
     * @return User
     */
    public function update(array $data, int $id): User;

    /**
     * Delete user by ID
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
