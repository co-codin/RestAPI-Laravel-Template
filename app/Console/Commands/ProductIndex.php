<?php

namespace App\Console\Commands;

use Elasticsearch\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class ProductIndex extends Command
{
    protected $signature = 'search:reindex';

    protected $description = 'ProductIndex products';

    public function __construct(protected Client $elasticsearch)
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
}
