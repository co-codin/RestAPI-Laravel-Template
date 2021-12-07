<?php

namespace Modules\Review\Enums;

use App\Enums\BaseEnum;

/**
 * @method static static LESS_MONTH()
 * @method static static SEVERAL_MONTHS()
 * @method static static MORE_YEAR()
 */
class ProductReviewExperience extends BaseEnum
{
    const LESS_MONTH = 1;
    const SEVERAL_MONTHS = 2;
    const MORE_YEAR = 3;
}
