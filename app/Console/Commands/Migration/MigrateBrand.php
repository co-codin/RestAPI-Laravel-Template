<?php

namespace App\Console\Commands\Migration;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\Brand\Models\Brand;

class MigrateBrand extends Command
{
    protected $signature = 'migrate:brand';

    protected $description = 'Migrate Brands';

    public function handle()
    {
        $oldBrands = DB::connection('old_medeq_mysql')
            ->table('brands')
            ->get();

        foreach ($oldBrands as $oldBrand) {
            Brand::query()->insert(
                $this->transform($oldBrand)
            );
        }
    }

    protected function transform($item)
    {
        return [
            'id' => $item->id,
            'name' => $item->title,
            'slug' => $item->slug,
            'image' => $item->image,
            'website' => $item->website,
            'full_description' => $item->full_description,
            'status' => $item->status,
            'is_in_home' => $item->in_home === 1 ? true : false,
            'position' => $item->position,
            'country' => $item->country,
            'short_description' => $item->short_description,
            'created_at' => $item->created_at,
            'updated_at' => $item->updated_at,
        ];
    }
}
