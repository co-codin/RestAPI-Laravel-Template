<?php

namespace Modules\Category\Listeners;

use Elasticsearch\Client;
use Modules\Category\Events\CategorySaved;
use Modules\Category\Http\Resources\Index\CategorySearchResource;

class ReindexCategory
{
    public function __construct(
        protected Client $elasticsearch,
    ) {}

    public function handle(CategorySaved $event)
    {
        $model = $event->category;

        $this->elasticsearch->index([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'id' => $model->getKey(),
            'body' => with(new CategorySearchResource($model))->toArray(request()),
        ]);
    }
}
