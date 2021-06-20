<?php

namespace Modules\Export\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Modules\Export\Services\Generator\Market\GoogleMarketGenerator;


class GenerateGoogleMarket extends Command
{
    protected $signature = 'generate:google-market {parameters}';

    protected $description = 'generate xml for google market';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(GoogleMarketGenerator $googleMarketGenerator)
    {
        $parameters = $this->argument('parameters');

        $googleMarketGenerator->generate($parameters);

        $this->info("Generated file url: " . url("/uploads/" . Arr::get($parameters, 'filename') . '.xml'));
    }
}
