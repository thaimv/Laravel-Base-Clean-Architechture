<?php

namespace App\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;

// Domain Repositories
use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Repositories\PasswordResetTokenRepositoryInterface;

// Domain Services
use App\Domain\Services\AuthServiceInterface;
use App\Domain\Services\ConfigServiceInterface;
use App\Domain\Services\HashServiceInterface;
use App\Domain\Services\MailServiceInterface;
use App\Domain\Services\StringGeneratorInterface;
use App\Domain\Services\TokenServiceInterface;
use App\Domain\Services\UserServiceInterface;

// Infrastructure Repositories
use App\Infrastructure\Repositories\EloquentUserRepository;
use App\Infrastructure\Repositories\EloquentPasswordResetTokenRepository;

// Infrastructure Services
use App\Infrastructure\Services\Auth\AuthService;
use App\Infrastructure\Services\Auth\JwtTokenService;
use App\Infrastructure\Services\Common\LaravelConfigService;
use App\Infrastructure\Services\Common\LaravelHashService;
use App\Infrastructure\Services\Common\LaravelStringGenerator;
use App\Infrastructure\Services\Mail\LaravelMailService;
use App\Infrastructure\Services\User\UserService;

class CleanArchitectureServiceProvider extends ServiceProvider
{
    /**
     * All bindings for Clean Architecture
     *
     * @var array
     */
    public array $bindings = [
        // Repositories
        UserRepositoryInterface::class => EloquentUserRepository::class,
        PasswordResetTokenRepositoryInterface::class => EloquentPasswordResetTokenRepository::class,

        // Domain Services
        AuthServiceInterface::class => AuthService::class,
        UserServiceInterface::class => UserService::class,
        MailServiceInterface::class => LaravelMailService::class,
        TokenServiceInterface::class => JwtTokenService::class,
        HashServiceInterface::class => LaravelHashService::class,
        StringGeneratorInterface::class => LaravelStringGenerator::class,
        ConfigServiceInterface::class => LaravelConfigService::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        foreach ($this->bindings as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
