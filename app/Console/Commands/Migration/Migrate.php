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
        $this->migrate('migrate:fresh --force');
        $this->migrate('migrate:brand');
        $this->migrate('migrate:category');
        $this->migrate('migrate:currency');
        $this->migrate('migrate:achievement');
        $this->migrate('migrate:news');
        $this->migrate('migrate:redirect');
        $this->migrate('migrate:page');
        $this->migrate('migrate:publication');
        $this->migrate('migrate:product');
        $this->migrate('migrate:product_variation');
        $this->migrate('migrate:product_category');
        $this->migrate('migrate:property');
        $this->migrate('migrate:canonical');
        $this->migrate('migrate:product_property');
        $this->migrate('migrate:filter');
        $this->migrate('migrate:seo-rule');
        $this->migrate('migrate:seo');
        $this->migrate('migrate:customer-review');
    }

    protected function migrate($command): void
    {
        $this->info("Running command: \"$command\"");
        Artisan::call($command);
    }
}
