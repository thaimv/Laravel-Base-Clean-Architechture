<?php

namespace App\Infrastructure\Persistence\Eloquent\Mappers;

use App\Domain\Entities\PasswordResetToken;
use App\Infrastructure\Persistence\Eloquent\Models\PasswordResetTokenModel;
use App\Shared\Constants\DateFormat;
use DateTimeImmutable;

/**
 * Mapper to convert between PasswordResetToken Entity and PasswordResetTokenModel
 */
class PasswordResetTokenMapper
{
    /**
     * Convert Eloquent Model to Domain Entity
     */
    public static function toEntity(PasswordResetTokenModel $model): PasswordResetToken
    {
        return new PasswordResetToken(
            id: $model->id,
            email: $model->email,
            token: $model->token,
            expiredAt: new DateTimeImmutable($model->expired_at->format(DateFormat::DATETIME_YMD_HIS)),
        );
    }

    /**
     * Convert Domain Entity to array for Eloquent Model
     */
    public static function toModelData(PasswordResetToken $entity): array
    {
        return [
            'email' => $entity->email,
            'token' => $entity->token,
            'expired_at' => $entity->expiredAt->format(DateFormat::DATETIME_YMD_HIS),
        ];
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
