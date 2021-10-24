<?php

namespace Modules\Export\Enum;

use App\Enums\BaseEnum;
use Illuminate\Support\Arr;

class ExportFrequency extends BaseEnum
{
    const MANUALLY = 1;

    const EVERY_30_MINUTES = 2;

    const HOURLY = 3;

    const EVERY_3_HOURS = 4;

    const DAILY = 5;

    const WEEKLY = 6;

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
