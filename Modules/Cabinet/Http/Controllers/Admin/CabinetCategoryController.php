<?php

namespace Modules\Cabinet\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Cabinet\Http\Requests\CabinetCategoryUpdateRequest;
use Modules\Cabinet\Http\Resources\CabinetResource;
use Modules\Cabinet\Models\Cabinet;
use Modules\Cabinet\Services\CabinetCategoryStorage;

class CabinetCategoryController extends Controller
{
    public function __construct(
        protected CabinetCategoryStorage $cabinetCategoryStorage
    ) {}

    public function update(Cabinet $cabinet, CabinetCategoryUpdateRequest $request)
    {
        $this->authorize('update', $cabinet);

        $this->cabinetCategoryStorage->update($cabinet, $request->input('categories'));

        return new CabinetResource($cabinet);
    }
}
