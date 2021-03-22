<?php

namespace App\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class BaseJsonResource extends JsonResource
{
    public function toArray($request): array
    {
        return parent::toArray($request);
    }

    protected function whenRequested($field, $value)
    {
        return $this->when(array_key_exists($field, $this->attributesToArray()), $value);
    }
}
