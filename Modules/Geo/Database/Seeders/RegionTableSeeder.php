<?php

namespace Modules\Geo\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Geo\Database\Seeders\Data\GeoData;
use Modules\Geo\Models\Region;

class RegionTableSeeder extends Seeder
{
    public function run()
    {
        foreach (GeoData::getRegionData() as $region) {
            Region::query()->create([
                'name' => $region['name'],
                'name_with_type' => $region['name_with_type'],
                'federal_district' => $region['federal_district'],
                'iso' => $region['iso_code'],
            ]);
        }
    }
}
