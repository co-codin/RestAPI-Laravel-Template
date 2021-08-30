<?php

namespace Modules\Product\Listeners;

use Elasticsearch\Client;
use Modules\Product\Events\ProductSaved;
use Modules\Search\Services\Indices\ProductIndex;
use Modules\Search\Services\Indices\ProductSearchResource;

class ReindexProduct
{
    public function __construct(
        protected Client $elasticsearch,
        protected ProductIndex $index
    ) {}

    public function handle(ProductSaved $event)
    {
        $model = $event->product;

        $this->elasticsearch->index([
            'index' => $this->index->name(),
            'id' => $model->getKey(),
            'body' => new ProductSearchResource($model),
        ]);
    }
}
