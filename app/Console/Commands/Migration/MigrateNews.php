<?php

namespace App\Console\Commands\Migration;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\News\Models\News;

class MigrateNews extends Command
{
    protected $signature = 'migrate:news';

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
        $data = [
            'id' => $item->id,
            'name' => $item->title,
            'slug' => $item->slug,
            'short_description' => $item->short_description,
            'full_description' => $item->full_description,
            'status' => $item->status,
            'image' => ltrim($item->image, "/"),
            'view_num' => $item->views_num,
            'is_in_home' => $item->in_home === 1,
            'published_at' => $item->news_date,
            'assigned_by_id' => 1,
            'created_at' => $item->created_at,
            'updated_at' => $item->updated_at,
        ];

        if ($item->status === 4) {
            array_merge($data, [
                'deleted_at' => Carbon::now(),
                'status' => 2,
            ]);
        }

        return $data;
    }
}
