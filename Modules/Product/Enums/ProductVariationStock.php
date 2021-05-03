<?php


namespace Modules\Product\Enums;


use App\Enums\BaseEnum;

class ProductVariationStock extends BaseEnum
{
    const InStock = 1;
    const UnderTheOrder = 2;
    const ComingSoon = 3;
    const OutOfProduction = 4;
    const MissingRegCertificate = 5;
}
