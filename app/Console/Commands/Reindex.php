<?php

namespace App\Console\Commands;

use Elasticsearch\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class Reindex extends Command
{
    protected $signature = 'search:reindex';

    protected $description = 'Reindex products';

    private Client $elasticsearch;

    public function __construct(Client $elasticsearch)
    {
        parent::__construct();
        $this->elasticsearch = $elasticsearch;
    }

    public function handle()
    {
        return 0;
    }

    private function getIndices(): Collection
    {
        $indices = collect(config('elasticsearch.indices'));
        $tables = $this->option('tables');

        if (!is_null($tables)) {
            $tables = trim($tables, ',');
            $tables = explode(',', $tables);

            $indices = $indices->filter(function ($index, $class) use ($tables) {
                $classTable = (new $class)->getTable();
                return array_key_exists($classTable, array_flip($tables));
            });

            if ($indices->isEmpty()) {
                throw new \LogicException('the tables option is entered incorrectly');
            }
        }

        return $indices;
    }
}
