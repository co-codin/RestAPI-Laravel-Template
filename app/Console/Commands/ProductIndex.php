<?php

namespace App\Console\Commands;

use App\Http\Resources\IndexCollection;
use App\Services\ElasticsearchService;
use Elasticsearch\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class ProductIndex extends Command
{
    protected $signature = 'search:reindex';

    protected $description = 'ProductIndex products';

    public function __construct(
        protected Client $elasticsearch,
        protected ElasticsearchService $elasticsearchService
    )
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->getProductsIndices()
            ->each(function ($index, $class) {
                $model = new $class;
                $searchIndex = $model->getSearchIndex();
                $indexName = $searchIndex . '_' . Carbon::now()->format('Y-m-d_H-i-s');

                $data = $this->getData(app($index['repository']), $indexName);

                $params = [
                    'index' => $indexName,
                    'body' => [
                        'settings' => $index['settings'],
                        'mappings' => $index['mappings'],
                    ],
                ];

                try {
                    $indexData = $this->elasticsearch->indices()->getAlias(['name' => $searchIndex]);       //exception
                    $oldIndexName = array_key_first($indexData);
                } catch (\Throwable $e) {
                    $this->elasticsearch->indices()->create($params);
                    $data->addToIndex($indexName);

                    $this->elasticsearch->indices()->putAlias(['index' => $indexName, 'name' => $searchIndex]);
                    return;
                }
            });
    }

    private function getProductsIndices(): Collection
    {
        $indices = collect(config('elasticsearch.indices'));

        $indices = $indices->filter(function ($index, $class) {
            $classTable = (new $class)->getTable();
            return array_key_exists($classTable, ['products']);
        });

        if ($indices->isEmpty()) {
            throw new \LogicException('the tables option is entered incorrectly');
        }

        return $indices;
    }

    private function getData(): IndexCollection
    {

        $indexData = collect($this->elasticsearchService->getToIndexData());
//            ->map(function (Model $model) use ($indexName) {
//                $model->offsetSet('indexName', $indexName);
//                return $model;
//            });

        return new IndexCollection($indexData);
    }
}
