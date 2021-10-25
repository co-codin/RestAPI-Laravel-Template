<?php

namespace Modules\Export\Enum;

use App\Enums\BaseEnum;
use Illuminate\Support\Arr;
use Modules\Export\Console\GenerateFacebookMarket;
use Modules\Export\Console\GenerateGoogleMarket;
use Modules\Export\Console\GenerateTiuMarket;
use Modules\Export\Console\GenerateYandexMarket;
use Modules\Export\Services\Generators\Avito\AvitoFeedGenerator;
use Modules\Export\Services\Generators\Facebook\FacebookFeedGenerator;
use Modules\Export\Services\Generators\GoogleMerchant\GoogleMerchantFeedGenerator;
use Modules\Export\Services\Generators\Tiu\TiuFeedGenerator;


class ExportType extends BaseEnum
{
    const TIU = 1;

    const GOOGLE_MERCHANT = 2;

    const FACEBOOK = 3;

    const AVITO = 4;

    public static array $generators = [
        self::TIU => TiuFeedGenerator::class,
        self::GOOGLE_MERCHANT => GoogleMerchantFeedGenerator::class,
        self::FACEBOOK => FacebookFeedGenerator::class,
        self::AVITO => AvitoFeedGenerator::class,
    ];
}
