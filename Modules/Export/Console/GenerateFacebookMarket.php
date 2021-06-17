<?php

namespace Modules\Export\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Modules\Export\Services\Generator\FacebookMarketGenerator;

class GenerateFacebookMarket extends Command
{
    protected $signature = 'generate:facebook-market {parameters}';

    protected $description = 'generate csv for facebook market';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(FacebookMarketGenerator $facebookMarketGenerator)
    {
        $parameters = $this->argument('parameters');

        $facebookMarketGenerator->generate($parameters);

        $this->info("Generated file url: " . url("/uploads/" . Arr::get($parameters, 'filename') . '.csv'));
    }
}
