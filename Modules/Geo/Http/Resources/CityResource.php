<?php

namespace Modules\Geo\Http\Resources;

use App\Enums\Status;
use App\Http\Resources\BaseJsonResource;
use Modules\Geo\Models\City;

/**
 * Class CityResource
 * @package Modules\Geo\Http\Resources
 * @mixin City
 */
class CityResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'status' => $this->whenRequested('status', Status::fromValue($this->status)),
            'order_points' => OrderPointResource::collection($this->whenLoaded('orderPoints')),
        ]);
    }
}
