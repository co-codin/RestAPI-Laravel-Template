<?php

namespace Modules\Geo\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Geo\Http\Requests\CityPageRequest;
use Modules\Geo\Http\Resources\CityPageResource;
use Modules\Geo\Http\Resources\CityResource;
use Modules\Geo\Models\City;
use Modules\Geo\Repositories\CityRepository;

class CityPageController extends Controller
{
    public function __construct(
        protected CityRepository $cityRepository
    ) {
        $this->cityRepository->resetCriteria();
    }

    public function citiesWithOrderPoint(CityPageRequest $cityPageRequest)
    {
        $name = $cityPageRequest->validated('name');

        dd(
            $name
        );

        $cities = $this->cityRepository
            ->scopeQuery(function ($query) {
                return $query
                    ->addSelect('id', 'name', 'slug')
                    ->withOrderPoints()
                    ->withCount('orderPoints AS orderPointCount')
                    ;
            })
            ->all();

        return CityPageResource::collection($cities);
    }

    public function show(int $city)
    {
        $city = $this->cityRepository->find($city);

        return new CityResource($city);
    }
}
