<?php

namespace Tests\Unit\Application\DTOs;

use App\Application\DTOs\Auth\LoginDTO;
use PHPUnit\Framework\TestCase;

class LoginDTOTest extends TestCase
{
    public function test_login_dto_can_be_created(): void
    {
        $dto = new LoginDTO(
            email: 'test@example.com',
            password: 'password123',
        );

        $this->assertEquals('test@example.com', $dto->email);
        $this->assertEquals('password123', $dto->password);
    }

    public function test_login_dto_from_array(): void
    {
        $dto = LoginDTO::fromArray([
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $this->assertEquals('test@example.com', $dto->email);
        $this->assertEquals('password123', $dto->password);
    }

    public function test_login_dto_to_array(): void
    {
        $dto = new LoginDTO(
            email: 'test@example.com',
            password: 'password123',
        );

        $array = $dto->toArray();

        $this->assertEquals('test@example.com', $array['email']);
        $this->assertEquals('password123', $array['password']);
    }
}

