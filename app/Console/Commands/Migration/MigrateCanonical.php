<?php

namespace App\Console\Commands\Migration;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\Seo\Models\Canonical;

class MigrateCanonical extends Command
{
    protected $signature = 'migrate:canonical';
    protected $description = 'Migrate canonicals';

    public function handle()
    {
        $oldCanonicals = DB::connection('old_medeq_mysql')
            ->table('canonicals')
            ->get();


        foreach ($oldCanonicals as $oldCanonical) {
            Canonical::query()->insert(
                $this->transform($oldCanonical)
            );
        }
    }

    protected function transform($item)
    {
        return [
            'id' => $item->id,
            'url' => $item->url,
            'canonical' => $item->canonical,
            'assigned_by_id' => 1,
            'created_at' => $item->created_at,
            'updated_at' => $item->updated_at,
        ];
    }
}
