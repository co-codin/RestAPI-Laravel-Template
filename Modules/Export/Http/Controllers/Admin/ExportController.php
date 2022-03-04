<?php

namespace Modules\Export\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Routing\Controller;
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
        $exportDto = ExportDto::fromFormRequest($request);

        if (!$exportDto->assigned_by_id) {
            $exportDto->assigned_by_id = auth('api')->id();
        }

        $export = $this->exportStorage->store($exportDto);

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
        $exportModel = $this->exportRepository->find($export);

        $this->exportStorage->delete($exportModel);

        return response()->noContent();
    }

    public function export(int $export)
    {
        $exportModel = $this->exportRepository->find($export);

        $generator = $this->exportService->getGenerator($exportModel);

        $generator->generate($exportModel);

        $exportModel->exported_at = Carbon::now();
        $exportModel->save();
    }
}
