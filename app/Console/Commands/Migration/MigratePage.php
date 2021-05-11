<?php

namespace App\Console\Commands\Migration;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\Page\Models\Page;

class MigratePage extends Command
{
    protected $signature = 'migrate:page';

    protected $description = 'Migrate page';

    protected $oldPages;

    public function __construct()
    {
        parent::__construct();
        $this->oldPages = DB::connection('old_medeq_mysql')->table('pages')->get();
    }

    public function handle()
    {
        foreach ($this->oldPages as $oldPage) {
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
            $parent = $this->oldPages->where('id', '=', $item->parent_id)->first();
            while(!is_null($parent)) {
                array_push($slugs, $parent->slug);
                $parent = $this->oldPages->where('id', '=',  $parent->parent_id)->first();
            }
            dd(
                implode('/', $slugs)
            );
            return implode('/', $slugs) . $item->slug;
        } else {
            return $item->slug;
        }
    }
}
