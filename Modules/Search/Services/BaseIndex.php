<?php

namespace Modules\Search\Services;

use Elasticsearch\Client;
use Modules\Search\Contracts\SearchIndex;

abstract class BaseIndex implements SearchIndex
{
    public function __construct(
        protected Client $elasticsearch,
    ) {}

    public function create(?string $indexName = null): void
    {
        $params = [
            'index' => $indexName ?? $this->name(),
            'body' => [
                'settings' => $this->settings(),
                'mappings' => $this->mappings(),
            ],
        ];

        $this->elasticsearch->indices()->create($params);
    }

    public function delete(?string $indexName = null): void
    {
        try {
            $this->elasticsearch->indices()->delete([
                'index' => $indexName ?? $this->name()
            ]);
        }
        catch (\Throwable $e) {}
    }
}
