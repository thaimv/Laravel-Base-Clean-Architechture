<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\PasswordResetToken;

interface PasswordResetTokenRepositoryInterface
{
    /**
     * Find token by email
     *
     * @param string $email
     * @return PasswordResetToken|null
     */
    public function findByEmail(string $email): ?PasswordResetToken;

    /**
     * Delete token by email
     *
     * @param string $email
     * @return bool
     */
    public function deleteByEmail(string $email): bool;

    /**
     * Create a new token
     *
     * @param array $data
     * @return PasswordResetToken
     */
    public function create(array $data): PasswordResetToken;

    /**
     * Update token by email
     *
     * @param string $email
     * @param array $data
     * @return PasswordResetToken
     */
    public function updateByEmail(string $email, array $data): PasswordResetToken;
}
