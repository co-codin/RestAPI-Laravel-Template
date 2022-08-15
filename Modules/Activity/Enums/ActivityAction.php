<?php

namespace Modules\Activity\Enums;

use App\Enums\BaseEnum;

class ActivityAction extends BaseEnum
{
    const DELETED = 'deleted';

    const UPDATED = 'updated';

    const CREATED = 'created';

    const UPDATE_CATEGORIES = 'updated categories';
}
