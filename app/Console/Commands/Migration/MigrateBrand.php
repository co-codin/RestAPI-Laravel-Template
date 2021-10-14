<?php

namespace App\Console\Commands\Migration;

use App\Models\FieldValue;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Brand\Models\Brand;

class MigrateBrand extends Command
{
    protected $signature = 'migrate:brand';

    protected $description = 'Migrate Brands';

    public function handle()
    {
        Model::unguard();

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
            'image' => !is_null($item->image) ? ltrim($item->image, "/") : null,
            'website' => $item->website,
            'full_description' => $item->full_description,
            'status' => $item->status,
            'is_in_home' => $item->in_home === 1,
            'position' => $item->position,
            'country_id' => $item->country
                ? FieldValue::query()->firstOrCreate(['value' => $item->country])->id
                : null,
            'short_description' => $item->short_description,
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
}
