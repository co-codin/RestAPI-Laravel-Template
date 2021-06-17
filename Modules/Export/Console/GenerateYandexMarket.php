<?php

namespace Modules\Export\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Modules\Export\Services\Generator\YandexMarketGenerator;

class GenerateYandexMarket extends Command
{
    protected $signature = 'generate:yandex-market {parameters}';

    protected $description = 'generate xml for yandex market';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(YandexMarketGenerator $yandexMarketGenerator)
    {
        $parameters = $this->argument('parameters');

        $yandexMarketGenerator->generate($parameters);

        $this->info("Generated file url: " . url("/uploads/" . Arr::get($parameters, 'filename') . '.xml'));
    }
}
