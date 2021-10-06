<?php


namespace Modules\Product\Enums;


use App\Enums\BaseEnum;

class ProductVariationCondition extends BaseEnum
{
    const NEW = 1;
    const DEMO = 2;
    const RESTORED = 3;
    const USED = 4;
}
