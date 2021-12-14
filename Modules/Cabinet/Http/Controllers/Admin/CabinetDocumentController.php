<?php

namespace Modules\Cabinet\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Cabinet\Http\Requests\CabinetDocumentUpdateRequest;
use Modules\Cabinet\Http\Resources\CabinetResource;
use Modules\Cabinet\Repositories\CabinetRepository;
use Modules\Cabinet\Services\CabinetDocumentStorage;

class CabinetDocumentController extends Controller
{
    public function __construct(
        protected CabinetRepository $cabinetRepository,
        protected CabinetDocumentStorage $cabinetDocumentStorage
    ) {}

    public function update(int $cabinet, CabinetDocumentUpdateRequest $request)
    {
        $cabinetModel = $this->cabinetRepository->find($cabinet);

        $this->cabinetDocumentStorage->update($cabinetModel, $request->input('documents'));

        return new CabinetResource($cabinetModel);
    }
}
