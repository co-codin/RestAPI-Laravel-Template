<?php

namespace App\Console\Commands\Migration;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\Seo\Models\SeoRule;

class MigrateSeoRule extends Command
{
    protected $signature = 'migrate:seo-rule';

    protected $description = 'Migrate seo rules';

    public function handle()
    {
        $oldSeoRules = DB::connection('old_medeq_mysql')
            ->table('seo_rules')
            ->get();

        foreach ($oldSeoRules as $oldSeoRule) {
            SeoRule::query()->insert(
                $this->transform($oldSeoRule)
            );
        }
    }

    protected function transform($item)
    {
        return [
            'id' => $item->id,
            'name' => $item->title,
            'url' => $item->url,
            'assigned_by_id' => 1,
            'created_at' => $item->created_at,
            'updated_at' => $item->updated_at,
        ];
    }
}
