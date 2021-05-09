<?php

namespace App\Console\Commands\Migration;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Migrate extends Command
{
    protected $signature = 'migrate';

    protected $description = 'Migrate';

    public function handle()
    {
        Artisan::call('migrate:brand');
    }
}
