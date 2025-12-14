<?php

namespace App\Shared\Constants;

/**
 * Date Format Constants - Pure PHP (no framework dependency)
 * Naming convention: {type}_{format_pattern}
 */
final class DateFormat
{
    // Standard formats (Y-m-d H:i:s)
    public const DATETIME_YMD_HIS = 'Y-m-d H:i:s';
    public const DATE_YMD = 'Y-m-d';
    public const TIME_HIS = 'H:i:s';

    // Display formats (d/m/Y H:i:s)
    public const DATETIME_DMY_HIS = 'd/m/Y H:i:s';
    public const DATE_DMY = 'd/m/Y';

    // ISO formats
    public const DATETIME_ISO8601 = 'c';
    public const DATE_ISO8601 = 'Y-m-d';
}
