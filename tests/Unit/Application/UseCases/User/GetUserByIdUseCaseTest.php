<?php

namespace Tests\Unit\Application\UseCases\User;

use App\Application\UseCases\User\GetUserByIdUseCase;
use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class GetUserByIdUseCaseTest extends TestCase
{
    private UserRepositoryInterface $userRepository;
    private GetUserByIdUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $this->useCase = new GetUserByIdUseCase($this->userRepository);
    }

    public function test_get_user_by_id_returns_user(): void
    {
        $user = new User(
            id: 1,
            name: 'John Doe',
            email: 'john@example.com',
            password: 'hashed_password',
            emailVerifiedAt: null,
            rememberToken: null,
            createdAt: new DateTimeImmutable(),
            updatedAt: new DateTimeImmutable(),
        );

        $this->userRepository
            ->expects($this->once())
            ->method('findById')
            ->with(1)
            ->willReturn($user);

        $result = $this->useCase->execute(1);

        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals(1, $result->id);
        $this->assertEquals('John Doe', $result->name);
    }

    public function test_get_user_by_id_returns_null_when_not_found(): void
    {
        $this->userRepository
            ->expects($this->once())
            ->method('findById')
            ->with(999)
            ->willReturn(null);

        $result = $this->useCase->execute(999);

        $this->assertNull($result);
    }
}

