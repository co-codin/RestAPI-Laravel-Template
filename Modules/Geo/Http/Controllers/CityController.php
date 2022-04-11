<?php

namespace Modules\Geo\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Geo\Http\Resources\CityResource;
use Modules\Geo\Models\City;
use Modules\Geo\Repositories\CityRepository;

class CityController extends Controller
{
    public function __construct(
        protected CityRepository $cityRepository
    ) {}

    public function all()
    {
        $cities = $this->cityRepository->all();

        return CityResource::collection($cities);
    }

    public function index()
    {
        $cities = $this->cityRepository->jsonPaginate();

        return CityResource::collection($cities);
    }

    public function show(int $city)
    {
        $city = $this->cityRepository->find($city);

        return new CityResource($city);
    }
}
