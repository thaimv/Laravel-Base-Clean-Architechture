<?php

namespace App\Infrastructure\Persistence\Eloquent\Mappers;

use App\Domain\Entities\User;
use App\Infrastructure\Persistence\Eloquent\Models\UserModel;
use App\Shared\Constants\DateFormat;
use DateTimeImmutable;

/**
 * Mapper to convert between User Entity and UserModel
 */
class UserMapper
{
    /**
     * Convert Eloquent Model to Domain Entity
     */
    public static function toEntity(UserModel $model): User
    {
        return new User(
            id: $model->id,
            name: $model->name,
            email: $model->email,
            password: $model->password,
            emailVerifiedAt: $model->email_verified_at
                ? new DateTimeImmutable($model->email_verified_at->format(DateFormat::DATETIME_YMD_HIS))
                : null,
            rememberToken: $model->remember_token,
            createdAt: $model->created_at
                ? new DateTimeImmutable($model->created_at->format(DateFormat::DATETIME_YMD_HIS))
                : null,
            updatedAt: $model->updated_at
                ? new DateTimeImmutable($model->updated_at->format(DateFormat::DATETIME_YMD_HIS))
                : null,
        );
    }

    /**
     * Convert Domain Entity to array for Eloquent Model
     */
    public static function toModelData(User $entity): array
    {
        return array_filter([
            'name' => $entity->name,
            'email' => $entity->email,
            'password' => $entity->password,
            'email_verified_at' => $entity->emailVerifiedAt?->format(DateFormat::DATETIME_YMD_HIS),
            'remember_token' => $entity->rememberToken,
        ], fn($value) => $value !== null);
    }

    /**
     * Convert collection of Models to collection of Entities
     */
    public static function toEntityCollection(iterable $models): array
    {
        $entities = [];
        foreach ($models as $model) {
            $entities[] = self::toEntity($model);
        }
        return $entities;
    }
}
