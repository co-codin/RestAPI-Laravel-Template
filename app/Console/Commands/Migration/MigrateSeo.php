<?php

namespace App\Console\Commands\Migration;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\Seo\Models\Seo;

class MigrateSeo extends Command
{
    protected $signature = 'migrate:seo';

    protected $description = 'Migrate seo';

    public function handle()
    {
        $oldSeos = DB::connection('old_medeq_mysql')
            ->table('seo')
            ->get();

        foreach ($oldSeos as $oldSeo) {
            Seo::query()->insert(
                $this->transform($oldSeo)
            );
        }
    }

    protected function transform($item)
    {
        return [
            'id' => $item->id,
            'seoable_type' => str_replace('Entities', 'Models', $item->seoable_type),
            'seoable_id' => $item->seoable_id,
            'is_enabled' => $item->is_enabled,
            'title' => $item->title,
            'description' => $item->description,
            'h1' => $item->h1,
            'meta_tags' => $item->meta_tags && $item->meta_tags !== "[]" ? $item->meta_tags : null,
        ];
    }
}
