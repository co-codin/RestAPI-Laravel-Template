<?php

namespace Modules\Geo\Database\Seeders;

use App\Enums\Status;
use Illuminate\Database\Seeder;
use Modules\Geo\Database\Seeders\Data\GeoData;
use Modules\Geo\Models\Region;

class CityTableSeeder extends Seeder
{
    public function run()
    {
        foreach (GeoData::getCityData() as $city) {
            $region = Region::query()->where('name_with_type', $city['region'])->first();

            $region->cities()->create(array_merge([
                'name' => $city['name'],
                'coordinate' => $city['coordinate'],
                'status' => Status::ACTIVE,
            ], $city['name'] === 'Москва' ? [
                'is_default' => 1,
            ] : []));
        }
    }
}
