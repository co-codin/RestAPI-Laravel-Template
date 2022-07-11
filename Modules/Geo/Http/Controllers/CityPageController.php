<?php

namespace Modules\Geo\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Geo\Http\Resources\CityPageResource;
use Modules\Geo\Repositories\CityRepository;

class CityPageController extends Controller
{
    public function __construct(
        protected CityRepository $cityRepository
    ) {
        $this->cityRepository->resetCriteria();
    }

    public function index()
    {
        $name = request()->get('name');

        $cities = $this->cityRepository
            ->scopeQuery(function ($query) {
                return $query
                    ->addSelect('id', 'name', 'slug')
                    ->withOrderPoints()
                    ->withCount('orderPoints AS orderPointCount')
                    ;
            })
            ->findWhere([
                ['name', 'LIkE', "%{$name}%"]
            ])
            ->all();

            return CityPageResource::collection($cities);
    }

    public function citiesWithSoldProduct()
    {
        $cities = $this->cityRepository
            ->scopeQuery(function ($query) {
                return $query
                    ->addSelect('id', 'name', 'slug', 'federal_district')
                    ->withSoldProducts()
                    ;
            })
            ->findWhere([
                ['federal_district', '!=', null]
            ])
            ->all()
            ;

        return CityPageResource::collection($cities);
    }

    public function show(string $city)
    {
        $city = $this->cityRepository
            ->scopeQuery(function ($query) {
                return $query->addSelect('id', 'federal_district');
            })
            ->findByField('slug', $city)
            ->first()
            ;

        return new CityPageResource($city);
    }
}
