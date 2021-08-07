<?php

namespace Modules\Geo\Database\Seeders;

use App\Enums\Status;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Geo\Database\Seeders\Data\GeoData;
use Modules\Geo\Models\City;

class CityTableSeederTableSeeder extends Seeder
{
    public function run()
    {
        $regions = collect(GeoData::getRegionData());

        $cities = collect(GeoData::getCityData());

        $data = $cities->map(function ($city, $key) use ($regions) {
            $region = $regions->where('name_with_type', '=', $city['region'])->first();
            return collect($city)->merge(['region' => $region]);
        });

        foreach ($data->toArray() as $item) {
            $region = $item['region'];
            City::query()->create([
                'region_name' => $region['name'],
                'region_name_with_type' => $region['name_with_type'],
                'federal_district' =>  $region['federal_district'],
                'iso' => $region['iso'],

                'city_name' => $item['name'],
                'status' => Status::ACTIVE,
                'is_default' => $item['name'] === 'Москва' ? 1 : 2,
                'coordinate' => $item['coordinate'],
            ]);
        }
    }
}
