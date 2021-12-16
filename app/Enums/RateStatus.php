<?php

namespace App\Enums;

/**
 * @method static static LIKE()
 * @method static static DISLIKE()
 * @method static static NONE()
 */
class RateStatus extends BaseEnum
{
    const LIKE = 1;
    const DISLIKE = 2;
    const NONE = 3;
}
