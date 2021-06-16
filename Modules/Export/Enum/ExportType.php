<?php

namespace Modules\Export\Enum;

use App\Enums\BaseEnum;

class ExportType extends BaseEnum
{
    const YANDEX_MARKET = 1;

    const TIU = 2;

    const GOOGLE_MERCHANT = 3;

    const FACEBOOK = 4;
}
