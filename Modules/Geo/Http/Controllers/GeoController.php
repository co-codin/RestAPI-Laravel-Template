<?php

namespace Modules\Geo\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Geo\Models\City;
use Modules\Geo\Models\Region;
use Modules\Geo\Services\SxGeo;

class GeoController extends Controller
{
    public function detectCity(Request $request)
    {
        $SxGeo = new SxGeo(storage_path('app/SxGeoCity.dat', SXGEO_BATCH | SXGEO_MEMORY));

        $defaultCity = City::query()->where('is_default', '=', 1)->first();

        if ($city = $SxGeo->getCityFull($request->ip())) {
            if ($region = Region::query()->where('iso', '=', $city['region']['iso'])->first()) {
                return $region->cities()->where('name', '=', $city['city']['name_ru'])->first() ??
                    City::query()
                        ->withCount('orderPoints')
                        ->where('region_id', '=', $region->id)
                        ->orderBy('order_points_count', 'desc')
                        ->first();
            } else {
                return $defaultCity;
            }
        } else {
            return $defaultCity;
        }
    }
}
