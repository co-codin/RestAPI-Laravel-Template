<?php

namespace Modules\Search\Services;

use Elasticsearch\Client;
use Illuminate\Support\Collection;
use Modules\Search\Contracts\SearchIndex;

class Indexer
{
    protected SearchIndex $index;

    public function __construct(
        protected Client $elasticsearch,
    ) {}

    public function index(SearchIndex $index)
    {
        $this->index = $index;

        $index->delete();
        $index->create();

        $this->indexData();
    }

    public function indexData()
    {
        app($this->index->repository())
            ->getItemsToIndex()
            ->chunk(500, function ($items) {
                $this->addToIndex($items);
            });
    }

    public function addToIndex(array|Collection $items): array
    {
        $params = [];

        foreach ($items as $item)
        {
            $params['body'][] = [
                'index' => [
                    '_id' => $item->getKey(),
                    '_index' => $this->index->name(),
                ],
            ];

            $params['body'][] = with(new ($this->index->resource())($item))
                ->toArray(request());
        }

        $result = $this->elasticsearch->bulk($params);

        if ((array_key_exists('errors', $result) && $result['errors'] != false) || (array_key_exists('Message', $result) && stristr('Request size exceeded', $result['Message']) !== false))
        {
            throw new \Exception("Cant index data");
        }

        return $result;
    }
}
