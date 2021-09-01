<?php

namespace Modules\Export\Enum;

use App\Enums\BaseEnum;
use Illuminate\Support\Arr;
use Modules\Export\Console\GenerateFacebookMarket;
use Modules\Export\Console\GenerateGoogleMarket;
use Modules\Export\Console\GenerateTiuMarket;
use Modules\Export\Console\GenerateYandexMarket;


class ExportType extends BaseEnum
{
    const YANDEX_MARKET = 1;

    const TIU = 2;

    const GOOGLE_MERCHANT = 3;

    const FACEBOOK = 4;

    public static function getCommand(int $type): string
    {
        $commands = [
            self::YANDEX_MARKET => GenerateYandexMarket::class,
            self::TIU => GenerateTiuMarket::class,
            self::GOOGLE_MERCHANT => GenerateGoogleMarket::class,
            self::FACEBOOK => GenerateFacebookMarket::class,
        ];

        return Arr::get($commands, $type);
    }
}
