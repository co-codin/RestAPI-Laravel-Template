<?php

namespace Modules\Search\Services;

use Elasticsearch\Client;
use Illuminate\Support\Carbon;
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

        $searchIndex = $index->name();
        $indexName = $searchIndex . '_' . Carbon::now()->format('Y-m-d_H-i-s');

        try {
            $indexData = $this->elasticsearch->indices()->getAlias(['name' => $searchIndex]);       //exception
            $oldIndexName = array_key_first($indexData);
        } catch (\Throwable $e) {
            $index->create($indexName);
            $this->indexData($indexName);

            $this->elasticsearch->indices()->putAlias(['index' => $indexName, 'name' => $searchIndex]);
            return;
        }

        $index->create($indexName);
        $this->indexData($indexName);

        $this->elasticsearch->indices()->updateAliases([
            'body' => [
                'actions' => [
                    [
                        'remove' => [
                            'alias' => $searchIndex,
                            'index' => $oldIndexName,
                        ],
                    ],
                    [
                        'add' => [
                            'alias' => $searchIndex,
                            'index' => $indexName,
                        ],
                    ]
                ]
            ]
        ]);

        $this->elasticsearch->indices()->delete(['index' => $oldIndexName]);
    }

    public function indexData(?string $indexName = null)
    {
        app($this->index->repository())
            ->getItemsToIndex()
            ->chunk(500, function ($items) use ($indexName) {
                $this->addToIndex($items, $indexName);
            });
    }

    public function addToIndex(array|Collection $items, ?string $indexName = null): array
    {
        $params = [];

        foreach ($items as $item)
        {
            $params['body'][] = [
                'index' => [
                    '_id' => $item->getKey(),
                    '_index' => $indexName ?? $this->index->name(),
                ],
            ];

            $params['body'][] = with(new ($this->index->resource())($item))
                ->toArray(request());
        }

        $result = $this->elasticsearch->bulk($params);

        if ((array_key_exists('errors', $result) && $result['errors'] != false) || (array_key_exists('Message', $result) && stristr('Request size exceeded', $result['Message']) !== false))
        {
            ray($result);
//            dump(\Arr::get($result, 'errors'), \Arr::get($result, 'Message'));
            throw new \Exception("Cant index data");
        }

        return $result;
    }
}
