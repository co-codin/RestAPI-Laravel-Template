<?php


namespace Modules\Product\Enums;


use App\Enums\BaseEnum;

/**
 * @method static static IN_STOCK()
 * @method static static UNDER_THE_ORDER()
 * @method static static COMING_SOON()
 * @method static static OUT_OF_PRODUCTION()
 * @method static static MISSING_REG_CERTIFICATE()
 */
class Availability extends BaseEnum
{
    const IN_STOCK = 1;
    const UNDER_THE_ORDER = 2;
    const COMING_SOON = 3;
    const OUT_OF_PRODUCTION = 4;
    const MISSING_REG_CERTIFICATE = 5;
}
