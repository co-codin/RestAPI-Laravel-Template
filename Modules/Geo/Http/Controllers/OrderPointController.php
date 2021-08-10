<?php

namespace Modules\Geo\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Geo\Http\Resources\OrderPointResource;
use Modules\Geo\Models\OrderPoint;
use Modules\Geo\Repositories\OrderPointRepository;

class OrderPointController extends Controller
{
    public function __construct(
        protected OrderPointRepository $orderPointRepository
    ) {}

    public function index()
    {
        $orderPoints = $this->orderPointRepository->jsonPaginate();

        return OrderPointResource::collection($orderPoints);
    }

    public function show(int $order_point)
    {
        $order_point = $this->orderPointRepository->find($order_point);

        return new OrderPointResource($order_point);
    }
}
