<?php

namespace App\Domain\Services;

interface UserServiceInterface
{
    /**
     * Get paginated list of users
     *
     * @param array $params
     * @return mixed
     */
    public function list(array $params);

    /**
     * Get user by ID
     *
     * @param int $id
     * @return mixed
     */
    public function findById(int $id);

    /**
     * Create a new user
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Update user
     *
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data);

    /**
     * Delete user
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
