<?php

namespace Tests\Unit\Domain\Entities;

use App\Domain\Entities\PasswordResetToken;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class PasswordResetTokenTest extends TestCase
{
    public function test_token_can_be_created(): void
    {
        $token = new PasswordResetToken(
            id: 1,
            email: 'test@example.com',
            token: 'abc123',
            expiredAt: new DateTimeImmutable('+1 hour'),
        );

        $this->assertEquals(1, $token->id);
        $this->assertEquals('test@example.com', $token->email);
        $this->assertEquals('abc123', $token->token);
    }

    public function test_token_is_not_expired_when_future(): void
    {
        $token = new PasswordResetToken(
            id: 1,
            email: 'test@example.com',
            token: 'abc123',
            expiredAt: new DateTimeImmutable('+1 hour'),
        );

        $this->assertFalse($token->isExpired());
    }

    public function test_token_is_expired_when_past(): void
    {
        $token = new PasswordResetToken(
            id: 1,
            email: 'test@example.com',
            token: 'abc123',
            expiredAt: new DateTimeImmutable('-1 hour'),
        );

        $this->assertTrue($token->isExpired());
    }

    public function test_token_matches_correctly(): void
    {
        $token = new PasswordResetToken(
            id: 1,
            email: 'test@example.com',
            token: 'abc123',
            expiredAt: new DateTimeImmutable('+1 hour'),
        );

        $this->assertTrue($token->matches('abc123'));
        $this->assertFalse($token->matches('wrong_token'));
    }

    public function test_token_to_array(): void
    {
        $expiredAt = new DateTimeImmutable('2024-12-31 23:59:59');
        $token = new PasswordResetToken(
            id: 1,
            email: 'test@example.com',
            token: 'abc123',
            expiredAt: $expiredAt,
        );

        $array = $token->toArray();

        $this->assertEquals(1, $array['id']);
        $this->assertEquals('test@example.com', $array['email']);
        $this->assertEquals('abc123', $array['token']);
        $this->assertEquals('2024-12-31 23:59:59', $array['expired_at']);
    }
}

