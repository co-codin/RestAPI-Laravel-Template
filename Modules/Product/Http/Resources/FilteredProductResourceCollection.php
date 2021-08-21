<?php

namespace Modules\Product\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Search\Collections\FilteredCollection;

class FilteredProductResourceCollection extends ResourceCollection
{
    protected FilteredCollection $baseCollection;

    public function __construct($resource)
    {
        parent::__construct($resource);

        $this->baseCollection = $resource;
        $this->resource = $this->collectResource($resource);
    }

    public function toArray($request)
    {
        return [
            'data' => ProductResource::collection($this->collection),
            'meta' => [
                'total' => $this->baseCollection->totalHits(),
                'aggregations' => $this->baseCollection->getAggregations(),
            ],
        ];
    }
}
