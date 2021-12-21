<?php

namespace Modules\Cabinet\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Cabinet\Dto\CabinetDto;
use Modules\Cabinet\Http\Requests\CabinetDocumentUpdateRequest;
use Modules\Cabinet\Http\Resources\CabinetResource;
use Modules\Cabinet\Repositories\CabinetRepository;
use Modules\Cabinet\Services\CabinetStorage;

class CabinetDocumentController extends Controller
{
    public function __construct(
        protected CabinetRepository $cabinetRepository,
        protected CabinetStorage $cabinetStorage
    ) {}

    public function update(int $cabinet, CabinetDocumentUpdateRequest $request)
    {
        $model = $this->cabinetRepository->find($cabinet);

        $dto = CabinetDto::fromFormRequest($request);

        $this->cabinetStorage->update($model, $dto);

        return new CabinetResource($model);
    }
}
