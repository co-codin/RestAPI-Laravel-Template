<?php

namespace Modules\Export\Console;

use Illuminate\Console\Command;

class GenerateFacebookMarket extends Command
{
    protected $signature = 'generate:facebook-market';

    protected $description = 'generate csv for facebook market';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        //
    }
}
