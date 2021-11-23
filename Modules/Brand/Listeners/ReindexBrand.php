<?php

namespace Modules\Brand\Listeners;

use Elasticsearch\Client;
use Modules\Brand\Events\BrandSaved;
use Modules\Brand\Http\Resources\Index\BrandSearchResource;

class ReindexBrand
{
    public function __construct(
        protected Client $elasticsearch,
    ) {}

    public function handle(BrandSaved $event)
    {
        $model = $event->brand;

        $this->elasticsearch->index([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'id' => $model->getKey(),
            'body' => new BrandSearchResource($model),
        ]);
    }
}
