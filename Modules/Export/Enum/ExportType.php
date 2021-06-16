<?php

namespace Modules\Export\Enum;

use App\Enums\BaseEnum;
use Illuminate\Support\Arr;
use Modules\Export\Console\GenerateFacebookMarket;
use Modules\Export\Console\GenerateGoogleMarket;
use Modules\Export\Console\GenerateTiuMarket;
use Modules\Export\Console\GenerateYandexMarket;
use Modules\Export\Services\Generator\FacebookMarketGenerator;
use Modules\Export\Services\Generator\GeneratorInterface;
use Modules\Export\Services\Generator\GoogleMarketGenerator;
use Modules\Export\Services\Generator\TiuMarketGenerator;
use Modules\Export\Services\Generator\YandexMarketGenerator;
use phpDocumentor\Reflection\Types\Self_;

class ExportType extends BaseEnum
{
    const YANDEX_MARKET = 1;

    const TIU = 2;

    const GOOGLE_MERCHANT = 3;

    const FACEBOOK = 4;

    const COMMANDS = [
        self::YANDEX_MARKET => GenerateYandexMarket::class,
        self::TIU => GenerateTiuMarket::class,
        self::GOOGLE_MERCHANT => GenerateGoogleMarket::class,
        self::FACEBOOK => GenerateFacebookMarket::class,
    ];

    public static function getCommand(int $type): string
    {
        return Arr::get(self::COMMANDS, $type);
    }
}
