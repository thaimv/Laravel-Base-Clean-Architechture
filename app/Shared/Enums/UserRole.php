<?php

namespace App\Shared\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case USER = 'user';
    case MODERATOR = 'moderator';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrator',
            self::USER => 'User',
            self::MODERATOR => 'Moderator',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
