<?php

namespace Modules\Export\Enum;

use App\Enums\BaseEnum;

class ExportType extends BaseEnum
{
    const YANDEX = 'yandex';

    const TIU = 'tiu';

    const GOOGLE = 'google';

    const FACEBOOK = 'facebook';
}
