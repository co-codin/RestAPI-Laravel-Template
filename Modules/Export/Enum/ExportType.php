<?php

namespace Modules\Export\Enum;

use App\Enums\BaseEnum;
use Illuminate\Support\Arr;
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
        self::YANDEX_MARKET => 'generate:yandex-market',
        self::TIU => 'generate:tiu-market',
        self::GOOGLE_MERCHANT => 'generate:google-market',
        self::FACEBOOK => 'generate:facebook-market',
    ];

    public static function getCommand(int $type): string
    {
        return Arr::get(self::COMMANDS, $type);
    }
}
