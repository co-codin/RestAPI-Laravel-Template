<?php

namespace App\Console\Commands\Migration;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\Achievement\Models\Achievement;

class MigrateAchievement extends Command
{
    protected $signature = 'migrate:achievement';

    protected $description = 'Migrate achievement';

    public function handle()
    {
        $oldBrands = DB::connection('old_medeq_mysql')
            ->table('brands')
            ->get();

        foreach ($oldBrands as $oldBrand) {
            Achievement::query()->insert(
                $this->transform($oldBrand)
            );
        }
    }

    protected function transform($item)
    {

    }
}
