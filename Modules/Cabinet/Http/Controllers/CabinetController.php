<?php

namespace Modules\Cabinet\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Cabinet\Http\Resources\CabinetResource;
use Modules\Cabinet\Repositories\CabinetRepository;

class CabinetController extends Controller
{
    public function __construct(
        protected CabinetRepository $cabinetRepository
    ) {}

    public function index()
    {
        $cabinets = $this->cabinetRepository->jsonPaginate();

        return CabinetResource::collection($cabinets);
    }

    public function show(int $cabinet)
    {
        $cabinet = $this->cabinetRepository->find($cabinet);

        return new CabinetResource($cabinet);
    }
}
