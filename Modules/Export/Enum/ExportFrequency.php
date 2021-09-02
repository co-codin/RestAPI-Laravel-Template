<?php

namespace Modules\Export\Enum;

use App\Enums\BaseEnum;
use Illuminate\Support\Arr;

class ExportFrequency extends BaseEnum
{
    const EVERY_30_MINUTES = 1;

    const HOURLY = 2;

    const EVERY_3_HOURS = 3;

    const DAILY = 4;

    const WEEKLY = 5;

    const MANUALLY = 6;

    public static function getFrequency(int $number)
    {
        $frequencies = [
            self::EVERY_30_MINUTES => 'everyThirtyMinutes',
            self::HOURLY => 'hourly',
            self::EVERY_3_HOURS => 'everyThreeHours',
            self::DAILY => 'daily',
            self::WEEKLY => 'weekly',
        ];

        return Arr::get($frequencies, $number);
    }
}
