<?php


namespace Modules\Product\Enums;


use App\Enums\BaseEnum;

class ProductVariantStock extends BaseEnum
{
    const InStock = 1;
    const UnderTheOrder = 2;
    const ComingSoon = 3;
    const OutOfProduction = 4;
    const MissingRegCertificate = 5;
}
