<?php

namespace Modules\Geo\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Geo\Services\SxGeo;

class GeoController extends Controller
{
    public function detectIp(Request $request)
    {
        $request->validate([
            'ip' => 'required|ip'
        ]);

        $SxGeo = new SxGeo(storage_path('app/SxGeoCity.dat', SXGEO_BATCH | SXGEO_MEMORY));

        return $SxGeo->getCity($request->get('ip'));
    }
}
