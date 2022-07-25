<?php

namespace Modules\Export\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Modules\Export\Dto\ExportDto;
use Modules\Export\Http\Requests\ExportCreateRequest;
use Modules\Export\Http\Requests\ExportUpdateRequest;
use Modules\Export\Http\Resources\ExportResource;
use Modules\Export\Models\Export;
use Modules\Export\Repositories\ExportRepository;
use Modules\Export\Services\ExportService;
use Modules\Export\Services\ExportStorage;

class ExportController extends Controller
{
    public function __construct(
        protected ExportStorage $exportStorage,
        protected ExportRepository $exportRepository,
        protected ExportService $exportService
    ) {}

    public function store(ExportCreateRequest $request)
    {
        $this->authorize('create', Export::class);

        $exportDto = ExportDto::fromFormRequest($request);

        if (!$exportDto->assigned_by_id) {
            $exportDto->assigned_by_id = auth('sanctum')->id();
        }

        $export = $this->exportStorage->store($exportDto);

        return new ExportResource($export);
    }

    public function update(int $export, ExportUpdateRequest $request)
    {
        $export = $this->exportRepository->find($export);

        $this->authorize('update', $export);

        $export = $this->exportStorage->update($export, ExportDto::fromFormRequest($request));

        return new ExportResource($export);
    }

    public function destroy(int $export)
    {
        $export = $this->exportRepository->find($export);

        $this->authorize('delete', $export);

        $this->exportStorage->delete($export);

        return response()->noContent();
    }

    public function export(int $export)
    {
        $export = $this->exportRepository->find($export);

        $this->authorize('export', $export);

        $generator = $this->exportService->getGenerator($export);

        $generator->generate($export);

        $export->exported_at = Carbon::now();
        $export->save();
    }
}
