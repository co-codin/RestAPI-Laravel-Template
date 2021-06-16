<?php

namespace Modules\Export\Console;

use Illuminate\Console\Command;

class GenerateTiuMarket extends Command
{
    protected $signature = 'generate:tiu-market';

    protected $description = 'generate xml for tiu market';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        //
    }
}
