<?php

namespace Modules\Cabinet\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Cabinet\Http\Requests\CabinetCategoryUpdateRequest;
use Modules\Cabinet\Http\Resources\CabinetResource;
use Modules\Cabinet\Repositories\CabinetRepository;
use Modules\Cabinet\Services\CabinetCategoryStorage;

class CabinetCategoryController extends Controller
{
    public function __construct(
        protected CabinetRepository $cabinetRepository,
        protected CabinetCategoryStorage $cabinetCategoryStorage
    ) {}

    public function update(int $cabinet, CabinetCategoryUpdateRequest $request)
    {
        $cabinetModel = $this->cabinetRepository->find($cabinet);

        $this->cabinetCategoryStorage->update($cabinetModel, $request->input('categories'));

        return new CabinetResource($cabinetModel);
    }
}
