<?php


namespace Modules\Product\Enums;


use App\Enums\BaseEnum;
use Modules\Product\Services\Parsers\DealMedParser;
use Modules\Product\Services\Parsers\MedComplexParser;

class SupplierEnum extends BaseEnum
{
    const MEDCOMPLEX = 1;
    const DEALMED = 2;

    public static array $resourceServices = [
        self::MEDCOMPLEX => MedComplexParser::class,
        self::DEALMED => DealMedParser::class,
    ];
}
