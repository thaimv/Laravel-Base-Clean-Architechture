<?php

namespace Tests\Unit\Domain\Entities;

use App\Domain\Entities\User;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private function createUser(array $overrides = []): User
    {
        return new User(
            id: $overrides['id'] ?? 1,
            name: $overrides['name'] ?? 'John Doe',
            email: $overrides['email'] ?? 'john@example.com',
            password: $overrides['password'] ?? 'hashed_password',
            emailVerifiedAt: $overrides['emailVerifiedAt'] ?? null,
            rememberToken: $overrides['rememberToken'] ?? null,
            createdAt: $overrides['createdAt'] ?? new DateTimeImmutable(),
            updatedAt: $overrides['updatedAt'] ?? new DateTimeImmutable(),
        );
    }

    public function test_user_can_be_created(): void
    {
        $user = $this->createUser();

        $this->assertEquals(1, $user->id);
        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john@example.com', $user->email);
    }

    public function test_user_email_is_not_verified_when_null(): void
    {
        $user = $this->createUser(['emailVerifiedAt' => null]);

        $this->assertFalse($user->isEmailVerified());
    }

    public function test_user_email_is_verified_when_set(): void
    {
        $user = $this->createUser([
            'emailVerifiedAt' => new DateTimeImmutable(),
        ]);

        $this->assertTrue($user->isEmailVerified());
    }

    public function test_user_can_be_updated_with_new_fields(): void
    {
        $user = $this->createUser();
        $updatedUser = $user->withUpdatedFields(
            name: 'Jane Doe',
            email: 'jane@example.com',
        );

        $this->assertEquals('Jane Doe', $updatedUser->name);
        $this->assertEquals('jane@example.com', $updatedUser->email);
        $this->assertEquals($user->id, $updatedUser->id);
        $this->assertEquals($user->password, $updatedUser->password);
    }

    public function test_user_to_array(): void
    {
        $createdAt = new DateTimeImmutable('2024-01-01 10:00:00');
        $user = $this->createUser([
            'createdAt' => $createdAt,
            'updatedAt' => $createdAt,
        ]);

        $array = $user->toArray();

        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('name', $array);
        $this->assertArrayHasKey('email', $array);
        $this->assertEquals('2024-01-01 10:00:00', $array['created_at']);
    }
}

