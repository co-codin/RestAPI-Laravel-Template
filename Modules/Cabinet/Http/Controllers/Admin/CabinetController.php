<?php

namespace Modules\Cabinet\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Modules\Cabinet\Dto\CabinetDto;
use Modules\Cabinet\Http\Requests\CabinetCreateRequest;
use Modules\Cabinet\Http\Requests\CabinetUpdateRequest;
use Modules\Cabinet\Http\Resources\CabinetResource;
use Modules\Cabinet\Repositories\CabinetRepository;
use Modules\Cabinet\Services\CabinetStorage;

class CabinetController extends Controller
{
    public function __construct(
        protected CabinetStorage $cabinetStorage,
        protected CabinetRepository $cabinetRepository
    ) {}

    public function store(CabinetCreateRequest $cabinetCreateRequest)
    {
        $cabinetDto = CabinetDto::fromFormRequest($cabinetCreateRequest);

        $cabinet = $this->cabinetStorage->store($cabinetDto);

        return new CabinetResource($cabinet);
    }

    public function update(int $cabinet, CabinetUpdateRequest $cabinetUpdateRequest)
    {
        $cabinetModel = $this->cabinetRepository->find($cabinet);

        $cabinetModel = $this->cabinetStorage->update($cabinetModel, CabinetDto::fromFormRequest($cabinetUpdateRequest));

        return new CabinetResource($cabinetModel);
    }

    public function destroy(int $cabinet)
    {
        $cabinetModel = $this->cabinetRepository->find($cabinet);

        $this->cabinetStorage->delete($cabinetModel);

        return response()->noContent();
    }
}
