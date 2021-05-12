<?php

namespace App\Console\Commands\Migration;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Migrate extends Command
{
    protected $signature = 'migrate:old_db';

    protected $description = 'Migrate old medeq db';

    public function handle()
    {
        Artisan::call('migrate:brand');
        Artisan::call('migrate:category');
        Artisan::call('migrate:currency');
        Artisan::call('migrate:achievement');
        Artisan::call('migrate:news');
        Artisan::call('migrate:redirect');
        Artisan::call('migrate:page');
        Artisan::call('migrate:publication');
        Artisan::call('migrate:filter');
        Artisan::call('migrate:product');
        Artisan::call('migrate:product_variation');
        Artisan::call('migrate:property');
    }
}
