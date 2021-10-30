<?php

namespace Modules\Export\Enum;

use App\Enums\BaseEnum;
use Modules\Export\Services\Generators\Avito\AvitoFeedGenerator;
use Modules\Export\Services\Generators\Facebook\FacebookFeedGenerator;
use Modules\Export\Services\Generators\GoogleMerchant\GoogleMerchantFeedGenerator;
use Modules\Export\Services\Generators\PulsCen\PulsCenGenerator;
use Modules\Export\Services\Generators\Satom\SatomFeedGenerator;
use Modules\Export\Services\Generators\Tiu\TiuFeedGenerator;


class ExportType extends BaseEnum
{
    const TIU = 1;

    const GOOGLE_MERCHANT = 2;

    const FACEBOOK = 3;

    const AVITO = 4;

    const PULS_CEN = 5;

    const SATOM = 6;

    public static array $generators = [
        self::TIU => TiuFeedGenerator::class,
        self::GOOGLE_MERCHANT => GoogleMerchantFeedGenerator::class,
        self::FACEBOOK => FacebookFeedGenerator::class,
        self::AVITO => AvitoFeedGenerator::class,
        self::PULS_CEN => PulsCenGenerator::class,
        self::SATOM => SatomFeedGenerator::class,
    ];
}
