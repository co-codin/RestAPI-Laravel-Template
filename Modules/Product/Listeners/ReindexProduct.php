<?php

namespace Modules\Product\Listeners;

use Elasticsearch\Client;
use Modules\Product\Events\ProductSaved;

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
            'body' => $model->toSearchArray(),
        ]);
    }
}
