<?php

namespace Modules\Export\Enum;

use App\Enums\BaseEnum;

class ExportFrequency extends BaseEnum
{
    const EVERY_30_MINUTES = 1;

    const EVERY_60_MINUTES = 2;

    const EVERY_3_HOURS = 3;

    const DAILY = 4;

    const WEEKLY = 5;

    const MANUALLY = 6;
}
