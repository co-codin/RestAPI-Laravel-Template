<?php

namespace App\Console\Commands\Migration;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\Seo\Models\CanonicalEntity;

class MigrateCanonical extends Command
{
    protected $signature = 'migrate:canonical';
    protected $description = 'Migrate canonicals';

    public function handle()
    {
        $oldCanonicals = DB::connection('old_medeq_mysql')
            ->table('canonicals')
            ->get();

        $canonicalsArray = $oldCanonicals
            ->map(fn (object $item): array => (array)$item)
            ->toArray();

        CanonicalEntity::query()->insert($canonicalsArray);
    }
}
