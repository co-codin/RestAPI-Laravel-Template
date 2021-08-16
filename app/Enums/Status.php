<?php

namespace App\Enums;

/**
 * @method static static ACTIVE()
 * @method static static INACTIVE()
 * @method static static ONLY_URL()
 */
final class Status extends BaseEnum
{
    const ACTIVE = 1;
    const INACTIVE = 2;
    const ONLY_URL = 3;
}
