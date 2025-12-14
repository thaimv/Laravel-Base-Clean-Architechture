<?php

namespace App\Shared\Helpers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class Helper
{
    /**
     * Set default page and per_page values
     *
     * @param array $params
     * @return void
     */
    public static function pageAndPerPage(array &$params): void
    {
        $params['page'] = $params['page'] ?? config('common.default_page');
        $params['per_page'] = $params['per_page'] ?? config('common.default_per_page');
    }

    /**
     * Format datetime
     *
     * @param mixed $date
     * @param string $format
     * @return string|null
     */
    public static function formatDateTime(mixed $date, string $format = 'Y/m/d H:i:s'): ?string
    {
        return is_null($date) ? null : Carbon::parse($date)->format($format);
    }

    /**
     * Format token infos
     *
     * @param string $token
     * @return array
     */
    public static function formatTokenInfos(string $token): array
    {
        return [
            'access_token' => $token,
            'expires_in' => Auth::factory()->getTTL() * 60,
        ];
    }
}
