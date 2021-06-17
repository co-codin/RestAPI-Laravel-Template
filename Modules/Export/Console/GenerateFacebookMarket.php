<?php

namespace Modules\Export\Console;

use Illuminate\Console\Command;

class GenerateFacebookMarket extends Command
{
    protected $signature = 'generate:facebook-market {parameters}';

    protected $description = 'generate csv for facebook market';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $parameters = $this->argument('parameters');


    }
}
