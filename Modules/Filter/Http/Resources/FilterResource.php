<?php


namespace Modules\Filter\Http\Resources;


use App\Transformers\BaseJsonResource;

class FilterResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'category' => $this->whenLoaded('category'),
        ]);
    }
}
