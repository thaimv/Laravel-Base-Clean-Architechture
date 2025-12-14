<?php

namespace Tests\Unit\Application\UseCases\Auth;

use App\Application\DTOs\Auth\LoginDTO;
use App\Application\UseCases\Auth\LoginUseCase;
use App\Domain\Exceptions\AuthenticationException;
use App\Domain\Services\TokenServiceInterface;
use Tests\TestCase;

class LoginUseCaseTest extends TestCase
{
    private TokenServiceInterface $tokenService;
    private LoginUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tokenService = $this->createMock(TokenServiceInterface::class);
        $this->useCase = new LoginUseCase($this->tokenService);
    }

    public function test_login_success(): void
    {
        $dto = new LoginDTO(
            email: 'test@example.com',
            password: 'password123',
        );

        $this->tokenService
            ->expects($this->once())
            ->method('attempt')
            ->with($dto->toArray())
            ->willReturn('jwt_token_here');

        $this->tokenService
            ->expects($this->once())
            ->method('getExpirationTime')
            ->willReturn(3600);

        $result = $this->useCase->execute($dto);

        $this->assertEquals('jwt_token_here', $result['access_token']);
        $this->assertEquals(3600, $result['expires_in']);
    }

    public function test_login_failure_throws_exception(): void
    {
        $dto = new LoginDTO(
            email: 'test@example.com',
            password: 'wrong_password',
        );

        $this->tokenService
            ->expects($this->once())
            ->method('attempt')
            ->with($dto->toArray())
            ->willReturn(null);

        $this->expectException(AuthenticationException::class);

        $this->useCase->execute($dto);
    }
}

