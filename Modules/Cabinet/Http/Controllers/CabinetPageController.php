<?php

namespace Modules\Cabinet\Http\Controllers;

use App\Enums\Status;
use Illuminate\Routing\Controller;
use Modules\Cabinet\Http\Resources\CabinetResource;
use Modules\Cabinet\Repositories\CabinetRepository;
use Modules\Cabinet\Repositories\Criteria\CabinetPageCriteria;

class CabinetPageController extends Controller
{
    public function __construct(
        protected CabinetRepository $cabinetRepository
    ) {
        $this->cabinetRepository->resetCriteria();
    }

    public function index()
    {
        $cabinets = $this->cabinetRepository
            ->scopeQuery(function ($query) {
                return $query
                    ->addSelect('id', 'name', 'slug', 'image', 'category_id', 'view_num')
                    ->with(['category' => function ($query) {
                        $query->addSelect('id', 'name');
                    }])
                    ;
            })
            ->orderBy('name', 'asc')
            ->findWhere([
                'status' => Status::ACTIVE,
            ])
            ->all();

        return CabinetResource::collection($cabinets);
    }

    public function show(string $cabinet)
    {
        $brand = $this->cabinetRepository
            ->pushCriteria(CabinetPageCriteria::class)
            ->findByField('slug', $cabinet)
            ->first();

        return new CabinetResource($brand);
    }
}
