<?php

namespace App\Domain\Entities;

use App\Shared\Constants\DateFormat;
use DateTimeImmutable;

/**
 * PasswordResetToken Entity - Pure PHP class without framework dependencies
 */
readonly class PasswordResetToken
{
    public function __construct(
        public ?int $id,
        public string $email,
        public string $token,
        public DateTimeImmutable $expiredAt,
    ) {
    }

    /**
     * Check if token is expired
     */
    public function isExpired(): bool
    {
        return $this->expiredAt < new DateTimeImmutable();
    }

    /**
     * Check if token matches
     */
    public function matches(string $token): bool
    {
        return $this->token === $token;
    }

    /**
     * Convert to array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'token' => $this->token,
            'expired_at' => $this->expiredAt->format(DateFormat::DATETIME_YMD_HIS),
        ];
    }
}
