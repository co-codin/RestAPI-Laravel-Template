<?php

namespace Modules\Review\Enums;

use App\Enums\BaseEnum;

/**
 * @method static static LIKE()
 * @method static static DISLIKE()
 * @method static static NONE()
 */
class ProductReviewRateStatus extends BaseEnum
{
    const LIKE = 1;
    const DISLIKE = 2;
    const NONE = 3;
}
