<?php

namespace Modules\Cabinet\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Cabinet\Dto\CabinetDto;
use Modules\Cabinet\Http\Requests\CabinetDocumentUpdateRequest;
use Modules\Cabinet\Http\Resources\CabinetResource;
use Modules\Cabinet\Models\Cabinet;
use Modules\Cabinet\Repositories\CabinetRepository;
use Modules\Cabinet\Services\CabinetStorage;

class CabinetDocumentController extends Controller
{
    public function __construct(
        protected CabinetStorage $cabinetStorage,
        protected CabinetRepository $cabinetRepository
    ) {}

    public function update(int $cabinet, CabinetDocumentUpdateRequest $request)
    {
        $cabinet = $this->cabinetRepository->find($cabinet);

        $this->authorize('update', $cabinet);

        $this->cabinetStorage->update($cabinet, CabinetDto::fromFormRequest($request));

        return new CabinetResource($cabinet);
    }
}
