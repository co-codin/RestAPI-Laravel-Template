<?php

namespace Modules\Export\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Modules\Export\Services\Generator\TiuMarketGenerator;

class GenerateTiuMarket extends Command
{
    protected $signature = 'generate:tiu-market {parameters}';

    protected $description = 'generate xml for tiu market';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(TiuMarketGenerator $tiuMarketGenerator)
    {
        $parameters = $this->argument('parameters');

        $tiuMarketGenerator->generate($parameters);

        $this->info("Generated file url: " . url("/uploads/" . Arr::get($parameters, 'filename') . '.xml'));
    }
}
