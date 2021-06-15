<?php

namespace Modules\Export\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Export\Http\Requests\ExportCreateRequest;
use Modules\Export\Http\Requests\ExportUpdateRequest;
use Modules\Export\Repositories\ExportRepository;
use Modules\Export\Services\ExportStorage;

class ExportController extends Controller
{
    public function __construct(
        protected ExportRepository $exportRepository,
        protected ExportStorage $exportStorage
    ) {}

    public function store(ExportCreateRequest $request)
    {
        $export = $this->exportStorage->store();
    }

    public function update(int $export, ExportUpdateRequest $request)
    {

    }

    public function destroy(int $export)
    {

    }
}
