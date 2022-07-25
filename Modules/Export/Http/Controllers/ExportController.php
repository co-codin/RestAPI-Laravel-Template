<?php


namespace Modules\Export\Http\Controllers;


use App\Http\Controllers\Controller;
use Modules\Export\Http\Resources\ExportResource;
use Modules\Export\Models\Export;
use Modules\Export\Repositories\ExportRepository;

class ExportController extends Controller
{
    public function __construct(
        protected ExportRepository $exportRepository
    ) {}

    public function index()
    {
        $exports = $this->exportRepository->jsonPaginate();

        return ExportResource::collection($exports);
    }

    public function show(int $export)
    {
        $export = $this->exportRepository->find($export);

        return new ExportResource($export);
    }
}
