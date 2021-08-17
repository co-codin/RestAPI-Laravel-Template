<?php

namespace Modules\Geo\Services;

use Modules\Geo\Dto\OrderPointDto;
use Modules\Geo\Models\OrderPoint;

class OrderPointStorage
{
    public function store(OrderPointDto $orderPointDto)
    {
        $orderPoint = new OrderPoint($orderPointDto->toArray());

        if (!$orderPoint->save()) {
            throw new \LogicException('can not create order point.');
        }

        return $orderPoint;
    }

    public function update(OrderPoint $orderPoint, OrderPointDto $orderPointDto)
    {
        if (!$orderPoint->update($orderPointDto->toArray())) {
            throw new \LogicException('can not update order point.');
        }

        return $orderPoint;
    }

    public function delete(OrderPoint $orderPoint)
    {
        if (!$orderPoint->delete()) {
            throw new \LogicException('can not delete order point.');
        }
    }
}
