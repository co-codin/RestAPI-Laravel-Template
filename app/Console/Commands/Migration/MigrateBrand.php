<?php

namespace App\Console\Commands\Migration;

use Carbon\Carbon;
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
        $data = [
            'id' => $item->id,
            'name' => $item->title,
            'slug' => $item->slug,
            'image' => ltrim($item->image, "/"),
            'website' => $item->website,
            'full_description' => $item->full_description,
            'status' => $item->status,
            'is_in_home' => $item->in_home === 1,
            'position' => $item->position,
            'country' => $item->country,
            'short_description' => $item->short_description,
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
