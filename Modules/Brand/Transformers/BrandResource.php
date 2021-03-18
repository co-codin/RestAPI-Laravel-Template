<?php

namespace Modules\Brand\Transformers;

use App\Enums\Status;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $statusDescription = Status::getValue($this->status);
        return array_merge(parent::toArray($request), [
            'status' => [
                'label' => $this->status,
                'description' => $statusDescription,
            ],
        ]);
    }
}
