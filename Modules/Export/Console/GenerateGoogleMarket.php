<?php

namespace Modules\Export\Console;

use Illuminate\Console\Command;

class GenerateGoogleMarket extends Command
{
    protected $signature = 'generate:google-market';

    protected $description = 'generate xml for google market';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        //
    }
}
