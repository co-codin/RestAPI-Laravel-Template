<?php

namespace Modules\Search\Services;

use Elasticsearch\Client;
use Modules\Search\Contracts\SearchIndex;

abstract class BaseIndex implements SearchIndex
{
    public function __construct(
        protected Client $elasticsearch,
    ) {}

    public function create(): void
    {
        $params = [
            'index' => $this->name(),
            'body' => [
                'settings' => $this->settings(),
                'mappings' => $this->mappings(),
            ],
        ];

        $this->elasticsearch->indices()->create($params);
    }

    public function delete(): void
    {
        $this->elasticsearch->indices()->delete([
            'index' => $this->name()
        ]);
    }
}
