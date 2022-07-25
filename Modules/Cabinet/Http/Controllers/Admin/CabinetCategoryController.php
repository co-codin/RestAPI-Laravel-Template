<?php

namespace Modules\Cabinet\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Cabinet\Http\Requests\CabinetCategoryUpdateRequest;
use Modules\Cabinet\Http\Resources\CabinetResource;
use Modules\Cabinet\Models\Cabinet;
use Modules\Cabinet\Repositories\CabinetRepository;
use Modules\Cabinet\Services\CabinetCategoryStorage;

class CabinetCategoryController extends Controller
{
    public function __construct(
        protected CabinetCategoryStorage $cabinetCategoryStorage,
        protected CabinetRepository $cabinetRepository
    ) {}

    public function update(int $cabinet, CabinetCategoryUpdateRequest $request)
    {
        $cabinet = $this->cabinetRepository->find($cabinet);

        $this->authorize('update', $cabinet);

        $this->cabinetCategoryStorage->update($cabinet, $request->input('categories'));

        return new CabinetResource($cabinet);
    }
}
