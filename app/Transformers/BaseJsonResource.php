<?php

namespace App\Transformers;

use App\Enums\Status;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseJsonResource extends JsonResource
{
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'status' => $this->whenRequested('status', [
                'value' => $this->status,
                'description' => Status::getDescription($this->status),
            ]),
        ]);
    }

    protected function whenRequested($field, $value)
    {
        return $this->when(array_key_exists($field, $this->attributesToArray()), $value);
    }
}
