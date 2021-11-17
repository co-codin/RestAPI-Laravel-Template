<?php

namespace App\Console\Commands\Migration;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Category\Models\Category;

class MigrateCategory extends Command
{
    protected $signature = 'migrate:category';

    protected $description = 'Migrate category';

    protected $oldCategories;

    public function handle()
    {
        Model::unguard();

        $this->oldCategories = DB::connection('old_medeq_mysql')->table('categories')->get();

        foreach ($this->oldCategories as $oldCategory) {
            Category::query()->insert(
                $this->transform($oldCategory)
            );
        }
    }

    protected function transform($item)
    {
        $image = $item->parent_id && $item->status == 1
            ? "categories/{$item->slug}.jpg"
            : null;

        $data = [
            'id' => $item->id,
            'name' => $item->title,
            'slug' => $this->getSlug($item),
            '_lft' => $item->_lft,
            '_rgt' => $item->_rgt,
            'parent_id' => $item->parent_id,
            'status' => $item->status,
            'product_name' => $item->product_name,
            'image' => $image,
            'is_in_home' => $item->in_home === 1,
            'full_description' => $item->full_description,
            'assigned_by_id' => 1,
            'created_at' => $item->created_at,
            'updated_at' => $item->updated_at,
        ];

        if ($item->status == 4) {
            $data = array_merge($data, [
                'deleted_at' => Carbon::now(),
                'status' => 2,
            ]);
        }

        return $data;
    }

    protected function getSlug($item)
    {
        $slugs = [];

        if ($item->parent_id) {
            $parent = $this->oldCategories->where('id', '=', $item->parent_id)->first();
            while(!is_null($parent)) {
                array_push($slugs, $parent->slug);
                $parent = $this->oldCategories->where('id', '=',  $parent->parent_id)->first();
            }
            return implode('/', array_reverse($slugs)) . '/' . $item->slug;
        } else {
            return $item->slug;
        }
    }
}
