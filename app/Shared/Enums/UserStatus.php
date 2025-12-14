<?php

namespace App\Shared\Enums;

enum UserStatus: int
{
    case INACTIVE = 0;
    case ACTIVE = 1;
    case BANNED = 2;

    public function label(): string
    {
        return match ($this) {
            self::INACTIVE => 'Inactive',
            self::ACTIVE => 'Active',
            self::BANNED => 'Banned',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
