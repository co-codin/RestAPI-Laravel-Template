<?php

namespace App\Console\Commands\Migration;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\Category\Models\Category;

class MigrateCategory extends Command
{
    protected $signature = 'migrate:category';

    protected $description = 'Migrate category';

    public function handle()
    {
        // TODO recursive
        $oldCategories = DB::connection('old_medeq_mysql')
            ->table('categories')
            ->select('categories.*')
//            ->leftJoin('categories as parent_categories', 'parent_categories.id', '=', 'categories.parent_id')
            ->get()
            ;

        dd(
            $oldCategories
        );
        foreach ($oldCategories as $oldCategory) {
            Category::query()->insert(
                $this->transform($oldCategory)
            );
        }
    }

    protected function transform($item)
    {
        return [
            'id' => $item->id,
            'name' => $item->title,
            'slug' => $this->getSlug($item),
            '_lft' => $item->_lft,
            '_rgt' => $item->_rgt,
            'parent_id' => $item->parent_id,
            'status' => $item->status,
            'product_name' => $item->product_name,
            'image' => $item->image,
            'is_in_home' => $item->in_home === 1 ? true : false,
            'is_hidden_in_parents' => $item->hide_in_parents === 1 ? true : false,
            'full_description' => $item->full_description,
            'created_at' => $item->created_at,
            'updated_at' => $item->updated_at,
        ];
    }

    protected function getSlug($item)
    {

//        if ($item)
        //
    }
}
