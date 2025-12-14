<?php

namespace App\Infrastructure\Services\Common;

use App\Domain\Services\ConfigServiceInterface;

/**
 * Laravel Config Service Implementation
 */
class LaravelConfigService implements ConfigServiceInterface
{
    /**
     * Get a configuration value
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return config($key, $default);
    }
}
