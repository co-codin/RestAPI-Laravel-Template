<?php

namespace Modules\Geo\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Modules\Geo\Dto\OrderPointDto;
use Modules\Geo\Http\Requests\OrderPointCreateRequest;
use Modules\Geo\Http\Requests\OrderPointUpdateRequest;
use Modules\Geo\Http\Resources\OrderPointResource;
use Modules\Geo\Repositories\OrderPointRepository;
use Modules\Geo\Services\OrderPointStorage;

class OrderPointController extends Controller
{
    public function __construct(
        protected OrderPointStorage $orderPointStorage,
        protected OrderPointRepository $orderPointRepository
    ) {}

    public function store(OrderPointCreateRequest $request)
    {
        $orderPoint = $this->orderPointStorage->store(OrderPointDto::fromFormRequest($request));

        return new OrderPointResource($orderPoint);
    }

    public function update(int $order_point, OrderPointUpdateRequest $request)
    {
        $order_point = $this->orderPointRepository->find($order_point);

        $order_point = $this->orderPointStorage->update($order_point, OrderPointDto::fromFormRequest($request));

        return new OrderPointResource($order_point);
    }

    public function destroy(int $order_point)
    {
        $order_point = $this->orderPointRepository->find($order_point);

        $this->orderPointStorage->delete($order_point);

        return response()->noContent();
    }
}
