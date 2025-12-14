<?php

namespace Tests\Unit\Application\DTOs;

use App\Application\DTOs\User\CreateUserDTO;
use PHPUnit\Framework\TestCase;

class CreateUserDTOTest extends TestCase
{
    public function test_create_user_dto_can_be_created(): void
    {
        $dto = new CreateUserDTO(
            name: 'John Doe',
            email: 'john@example.com',
            password: 'password123',
        );

        $this->assertEquals('John Doe', $dto->name);
        $this->assertEquals('john@example.com', $dto->email);
        $this->assertEquals('password123', $dto->password);
    }

    public function test_create_user_dto_from_array(): void
    {
        $dto = CreateUserDTO::fromArray([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
        ]);

        $this->assertEquals('John Doe', $dto->name);
        $this->assertEquals('john@example.com', $dto->email);
        $this->assertEquals('password123', $dto->password);
    }

    public function test_create_user_dto_to_array(): void
    {
        $dto = new CreateUserDTO(
            name: 'John Doe',
            email: 'john@example.com',
            password: 'password123',
        );

        $array = $dto->toArray();

        $this->assertEquals('John Doe', $array['name']);
        $this->assertEquals('john@example.com', $array['email']);
        $this->assertEquals('password123', $array['password']);
    }
}

