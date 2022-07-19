<?php

namespace Modules\Cabinet\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Cabinet\Dto\CabinetDto;
use Modules\Cabinet\Http\Requests\CabinetCreateRequest;
use Modules\Cabinet\Http\Requests\CabinetUpdateRequest;
use Modules\Cabinet\Http\Resources\CabinetResource;
use Modules\Cabinet\Models\Cabinet;
use Modules\Cabinet\Repositories\CabinetRepository;
use Modules\Cabinet\Services\CabinetStorage;

class CabinetController extends Controller
{
    public function __construct(
        protected CabinetStorage $cabinetStorage
    ) {
        $this->authorizeResource(Cabinet::class, 'cabinet');
    }

    public function store(CabinetCreateRequest $cabinetCreateRequest)
    {
        $cabinetDto = CabinetDto::fromFormRequest($cabinetCreateRequest);

        $cabinet = $this->cabinetStorage->store($cabinetDto);

        return new CabinetResource($cabinet);
    }

    public function update(Cabinet $cabinet, CabinetUpdateRequest $cabinetUpdateRequest)
    {
        $cabinet = $this->cabinetStorage->update($cabinet, CabinetDto::fromFormRequest($cabinetUpdateRequest));

        return new CabinetResource($cabinet);
    }

    public function destroy(Cabinet $cabinet)
    {
        $this->cabinetStorage->destroy($cabinet);

        return response()->noContent();
    }
}
