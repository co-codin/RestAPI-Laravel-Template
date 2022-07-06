<?php

namespace Modules\Brand\Http\Controllers;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use Modules\Brand\Http\Resources\BrandPageResource;
use Modules\Brand\Repositories\BrandRepository;
use Modules\Brand\Repositories\Criteria\BrandPageCriteria;

class BrandPageController extends Controller
{
    public function __construct(
        protected BrandRepository $brandRepository
    ) {
        $this->brandRepository->resetCriteria();
    }

    public function index()
    {
        $brands = $this->brandRepository
            ->scopeQuery(function ($query) {
                return $query
                    ->addSelect('id', 'name', 'slug')
                    ->withCount('products AS productCount')
                    ;
            })
            ->orderBy('name', 'asc')
            ->findWhere([
                'status' => Status::ACTIVE,
            ])
            ->all();

        return BrandPageResource::collection($brands);
    }

    public function show(string $brand)
    {
        $brand = $this->brandRepository
            ->pushCriteria(BrandPageCriteria::class)
            ->findByField('slug', $brand)
            ->first();

        return new BrandPageResource($brand);
    }
}
