<?php

namespace Modules\Cabinet\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Cabinet\Dto\CabinetDto;
use Modules\Cabinet\Http\Requests\CabinetDocumentUpdateRequest;
use Modules\Cabinet\Http\Resources\CabinetResource;
use Modules\Cabinet\Models\Cabinet;
use Modules\Cabinet\Services\CabinetStorage;

class CabinetDocumentController extends Controller
{
    public function __construct(
        protected CabinetStorage $cabinetStorage
    ) {}

    public function update(Cabinet $cabinet, CabinetDocumentUpdateRequest $request)
    {
        $this->authorize('update', $cabinet);

        $this->cabinetStorage->update($cabinet, CabinetDto::fromFormRequest($request));

        return new CabinetResource($cabinet);
    }
}
