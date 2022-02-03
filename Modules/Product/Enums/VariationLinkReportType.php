<?php


namespace Modules\Product\Enums;

use App\Enums\BaseEnum;

/**
 * @method static static STATUS_CODE()
 * @method static static CHECK()
 * @method static static PRICE()
 * @method static static AVAILABILITY()
 * @method static static VARIATION_LINK_UPDATE()
 * @method static static PRODUCT_VARIATION_UPDATE()
 * @method static static DONE()
 */
class VariationLinkReportType extends BaseEnum
{
    const STATUS_CODE = 1;
    const CHECK = 2;
    const PRICE = 3;
    const AVAILABILITY = 4;
    const VARIATION_LINK_UPDATE = 5;
    const PRODUCT_VARIATION_UPDATE = 6;
    const DONE = 7;
}
