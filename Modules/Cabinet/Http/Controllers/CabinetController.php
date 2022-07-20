<?php

namespace Modules\Cabinet\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Cabinet\Http\Resources\CabinetResource;
use Modules\Cabinet\Models\Cabinet;
use Modules\Cabinet\Repositories\CabinetRepository;

class CabinetController extends Controller
{
    public function __construct(
        protected CabinetRepository $cabinetRepository
    ) {}

    public function index()
    {
        $this->authorize('viewAny', Cabinet::class);

        $cabinets = $this->cabinetRepository->jsonPaginate();

        return CabinetResource::collection($cabinets);
    }

    public function show(int $cabinet)
    {
        $cabinet = $this->cabinetRepository->find($cabinet);

        $this->authorize('view', $cabinet);

        return new CabinetResource($cabinet);
    }
}
