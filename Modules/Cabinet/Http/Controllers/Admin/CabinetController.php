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
        protected CabinetStorage $cabinetStorage,
        protected CabinetRepository $cabinetRepository
    ) {}

    public function store(CabinetCreateRequest $cabinetCreateRequest)
    {
        $this->authorize('create', Cabinet::class);

        $cabinetDto = CabinetDto::fromFormRequest($cabinetCreateRequest);

        $cabinet = $this->cabinetStorage->store($cabinetDto);

        return new CabinetResource($cabinet);
    }

    public function update(int $cabinet, CabinetUpdateRequest $cabinetUpdateRequest)
    {
        $cabinet = $this->cabinetRepository->find($cabinet);

        $this->authorize('update', $cabinet);

        $cabinet = $this->cabinetStorage->update($cabinet, CabinetDto::fromFormRequest($cabinetUpdateRequest));

        return new CabinetResource($cabinet);
    }

    public function destroy(int $cabinet)
    {
        $cabinet = $this->cabinetRepository->find($cabinet);

        $this->authorize('update', $cabinet);

        $this->cabinetStorage->destroy($cabinet);

        return response()->noContent();
    }
}
