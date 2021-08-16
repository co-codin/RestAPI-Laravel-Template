<?php

namespace App\Console\Commands\Migration;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\Publication\Models\Publication;

class MigratePublication extends Command
{
    protected $signature = 'migrate:publication';

    protected $description = 'Migrate publication';

    public function handle()
    {
        $oldPublications = DB::connection('old_medeq_mysql')
            ->table('publications')
            ->get();

        foreach ($oldPublications as $oldPublication) {
            Publication::query()->insert(
                $this->transform($oldPublication)
            );
        }
    }

    protected function transform($item)
    {
        return [
            'name' => $item->title,
            'url' => $item->url,
            'source' => $item->source,
            'is_enabled' => $item->status === 1,
            'published_at' => $item->published_at,
            'created_at' => $item->created_at,
            'updated_at' => $item->updated_at,
        ];
    }
}
