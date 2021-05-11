<?php

namespace App\Console\Commands\Migration;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\News\Models\News;

class MigratePublication extends Command
{
    protected $signature = 'migrate:publication';

    protected $description = 'Migrate publication';

    public function handle()
    {
        $oldPublications = DB::connection('old_medeq_mysql')
            ->table('publications')
            ->get();

        foreach ($oldNews as $item) {
            News::query()->insert(
                $this->transform($item)
            );
        }
    }
}
