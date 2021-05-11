<?php

namespace App\Console\Commands\Migration;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\Page\Models\Page;

class MigratePage extends Command
{
    protected $signature = 'migrate:page';

    protected $description = 'Migrate page';

    protected $oldPageQuery;

    public function __construct()
    {
        parent::__construct();
        $this->oldPageQuery = DB::connection('old_medeq_mysql')->table('pages');
    }

    public function handle()
    {
        foreach ($this->oldPageQuery->get() as $oldPage) {
            Page::query()->insert(
                $this->transform($oldPage)
            );
        }
    }

    protected function transform($item)
    {
        return [
            'id' => $item->id,
            'name' => $item->title,
            'slug' => $this->getSlug($item),
            'full_description' => $item->text,
            'status' => $item->status,
            'parent_id' => $item->parent_id,
            '_lft' => $item->_lft,
            '_rgt' => $item->_rgt,
            'created_at' => $item->created_at,
            'updated_at' => $item->updated_at,
        ];
    }

    protected function getSlug($item)
    {
        $slugs = [];

        if ($item->parent_id) {
            $parent = DB::connection('old_medeq_mysql')
                ->table('pages')
                ->where('id', '=', $item->parent_id)
                ->first();
            while(!is_null($parent)) {
                array_push($slugs, $parent->slug);
                $parent = DB::connection('old_medeq_mysql')
                    ->table('pages')
                    ->where('id', '=', $parent->parent_id)
                    ->first();
            }
            return implode('/', $slugs) . $item->slug;
        } else {
            return $item->slug;
        }
    }
}
