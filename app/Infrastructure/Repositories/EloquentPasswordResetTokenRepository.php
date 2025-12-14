<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\PasswordResetToken;
use App\Domain\Repositories\PasswordResetTokenRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Mappers\PasswordResetTokenMapper;
use App\Infrastructure\Persistence\Eloquent\Models\PasswordResetTokenModel;

class EloquentPasswordResetTokenRepository implements PasswordResetTokenRepositoryInterface
{
    public function __construct(
        protected PasswordResetTokenModel $model,
    ) {
    }

    /**
     * Find token by email
     *
     * @param string $email
     * @return PasswordResetToken|null
     */
    public function findByEmail(string $email): ?PasswordResetToken
    {
        $model = $this->model->query()
            ->where('email', $email)
            ->first();

        return $model ? PasswordResetTokenMapper::toEntity($model) : null;
    }

    /**
     * Delete token by email
     *
     * @param string $email
     * @return bool
     */
    public function deleteByEmail(string $email): bool
    {
        return $this->model->query()
            ->where('email', $email)
            ->delete() > 0;
    }

    /**
     * Create a new token
     *
     * @param array $data
     * @return PasswordResetToken
     */
    public function create(array $data): PasswordResetToken
    {
        $model = $this->model->query()->create($data);

        return PasswordResetTokenMapper::toEntity($model);
    }

    /**
     * Update token by email
     *
     * @param string $email
     * @param array $data
     * @return PasswordResetToken
     */
    public function updateByEmail(string $email, array $data): PasswordResetToken
    {
        $model = $this->model->query()
            ->where('email', $email)
            ->firstOrFail();

        $model->update($data);

        return PasswordResetTokenMapper::toEntity($model->fresh());
    }
}
