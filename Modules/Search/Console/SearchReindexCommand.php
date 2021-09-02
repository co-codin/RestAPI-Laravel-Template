<?php

namespace Modules\Search\Console;

use Elasticsearch\Client;
use Illuminate\Console\Command;
use Modules\Search\Contracts\SearchIndex;
use Modules\Search\Services\Indexer;

class SearchReindexCommand extends Command
{
    protected $signature = 'search:reindex';

    protected $description = 'Full reindex of database';

    protected Client $elasticsearch;

    protected Indexer $indexer;

    public function __construct(Client $elasticsearch, Indexer $indexer)
    {
        parent::__construct();

        $this->elasticsearch = $elasticsearch;
        $this->indexer = $indexer;
    }

    public function handle()
    {
        collect(config('search.indices'))
            ->map(fn($index) => app($index))
            ->filter(fn($index) => $index instanceof SearchIndex)
            ->each(fn($index) => $this->indexer->index($index));
    }
}
