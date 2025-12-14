<?php

namespace App\Domain\Services;

/**
 * Config Service Interface - For accessing configuration
 */
interface ConfigServiceInterface
{
    /**
     * Get a configuration value
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed;
}
