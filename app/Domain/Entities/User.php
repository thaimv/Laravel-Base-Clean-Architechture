<?php

namespace App\Domain\Entities;

use App\Shared\Constants\DateFormat;
use DateTimeImmutable;

/**
 * User Entity - Pure PHP class without framework dependencies
 */
readonly class User
{
    public function __construct(
        public ?int $id,
        public string $name,
        public string $email,
        public string $password,
        public ?DateTimeImmutable $emailVerifiedAt = null,
        public ?string $rememberToken = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
    ) {
    }

    /**
     * Check if email is verified
     */
    public function isEmailVerified(): bool
    {
        return $this->emailVerifiedAt !== null;
    }

    /**
     * Create a new User with updated fields
     */
    public function withUpdatedFields(
        ?string $name = null,
        ?string $email = null,
        ?string $password = null,
    ): self {
        return new self(
            id: $this->id,
            name: $name ?? $this->name,
            email: $email ?? $this->email,
            password: $password ?? $this->password,
            emailVerifiedAt: $this->emailVerifiedAt,
            rememberToken: $this->rememberToken,
            createdAt: $this->createdAt,
            updatedAt: new DateTimeImmutable(),
        );
    }

    /**
     * Convert to array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => $this->emailVerifiedAt?->format(DateFormat::DATETIME_YMD_HIS),
            'created_at' => $this->createdAt?->format(DateFormat::DATETIME_YMD_HIS),
            'updated_at' => $this->updatedAt?->format(DateFormat::DATETIME_YMD_HIS),
        ];
    }
}
