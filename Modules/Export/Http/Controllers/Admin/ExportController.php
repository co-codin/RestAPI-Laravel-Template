<?php

namespace Modules\Export\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Modules\Export\Dto\ExportDto;
use Modules\Export\Http\Requests\ExportCreateRequest;
use Modules\Export\Http\Requests\ExportUpdateRequest;
use Modules\Export\Http\Resources\ExportResource;
use Modules\Export\Repositories\ExportRepository;
use Modules\Export\Services\ExportService;
use Modules\Export\Services\ExportStorage;

class ExportController extends Controller
{
    public function __construct(
        protected ExportRepository $exportRepository,
        protected ExportStorage $exportStorage,
        protected ExportService $exportService
    ) {}

    public function store(ExportCreateRequest $request)
    {
        $export = $this->exportStorage->store(ExportDto::fromFormRequest($request));

        return new ExportResource($export);
    }

    public function update(int $export, ExportUpdateRequest $request)
    {
        $exportModel = $this->exportRepository->find($export);

        $exportModel = $this->exportStorage->update($exportModel, ExportDto::fromFormRequest($request));

        return new ExportResource($exportModel);
    }

    public function destroy(int $export)
    {
        $export = $this->exportRepository->find($export);

        $this->exportStorage->delete($export);

        return response()->noContent();
    }

    public function export(int $export)
    {
        $export = $this->exportRepository->find($export);

        $command = $this->exportService->determine($export);

        Artisan::call($command, array_merge($export->parameters, [
            'filename' => $export->filename,
        ]));
    }
}
