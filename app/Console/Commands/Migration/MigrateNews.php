<?php

namespace App\Console\Commands\Migration;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\News\Models\News;

class MigrateNews extends Command
{
    protected $signature = 'migrate:new';

    protected $description = 'Migrate news';

    public function handle()
    {
        $oldNews = DB::connection('old_medeq_mysql')
            ->table('news')
            ->get();

        foreach ($oldNews as $item) {
            News::query()->insert(
                $this->transform($item)
            );
        }
    }

    protected function transform($item)
    {
        return [
            'id' => $item->id,
            'name' => $item->title,
            'slug' => $item->slug,
            'short_description' => $item->short_description,
            'full_description' => $item->full_description,
            'status' => $item->status,
            'image' => $item->image,
            'is_in_home' => $item->in_home === 1 ? true : false,
            'published_at' => $item->news_date,
            'created_at' => $item->created_at,
            'updated_at' => $item->updated_at,
        ];
    }
}
