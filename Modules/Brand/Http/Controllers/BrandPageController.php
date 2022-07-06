<?php

namespace Modules\Brand\Http\Controllers;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use Modules\Brand\Http\Resources\BrandPageResource;
use Modules\Brand\Repositories\BrandRepository;

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

    }
}
