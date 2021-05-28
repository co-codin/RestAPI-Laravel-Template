<?php

namespace App\Console\Commands;

use Elasticsearch\Client;
use App\Http\Resources\IndexCollection;
use Elasticsearch\ClientBuilder;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Modules\Product\Repositories\ProductRepository;

class ProductIndex extends Command
{
    protected $signature = 'product:reindex';

    protected $description = 'Reindex products';

    protected Client $elasticsearch;

    public function __construct()
    {
        parent::__construct();

        $this->elasticsearch = ClientBuilder::create()->build();;
    }

    public function handle()
    {
        $this->getProductsIndices()
            ->each(function ($index, $class) {
                $model = new $class;
                $searchIndex = $model->getSearchIndex();
                $indexName = $searchIndex . '_' . Carbon::now()->format('Y-m-d_H-i-s');

                $data = $this->getData(app($index['repository']));

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
            return $classTable === 'products';
        });

        if ($indices->isEmpty()) {
            throw new \LogicException('the tables option is entered incorrectly');
        }

        return $indices;
    }

    private function getData(ProductRepository $repository): IndexCollection
    {
        $indexData = collect($repository->indexForProducts());

        return new IndexCollection($indexData);
    }
}
