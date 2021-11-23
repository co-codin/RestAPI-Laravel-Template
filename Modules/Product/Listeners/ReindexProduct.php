<?php

namespace Modules\Product\Listeners;

use Elasticsearch\Client;
use Modules\Product\Events\ProductSaved;
use Modules\Product\Http\Resources\Index\ProductSearchResource;

class ReindexProduct
{
    public function __construct(
        protected Client $elasticsearch,
    ) {}

    public function handle(ProductSaved $event)
    {
        $model = $event->product;

        $this->elasticsearch->index([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'id' => $model->getKey(),
            'body' => with(new ProductSearchResource($model))->toArray(request()),
        ]);
    }
}
