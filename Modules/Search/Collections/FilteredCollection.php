<?php

namespace Modules\Search\Collections;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class FilteredCollection extends Collection
{
    protected $took;
    protected $timed_out;
    protected $shards;
    protected $hits;
    protected $aggregations = null;

    public function __construct($items, $meta = null)
    {
        parent::__construct($items);

        if (is_array($meta)) {
            $this->setMeta($meta);
        }
    }

    public function setMeta(array $meta): self
    {
        $this->took = $meta['took'] ?? null;
        $this->timed_out = $meta['timed_out'] ?? null;
        $this->shards = $meta['_shards'] ?? null;
        $this->hits = $meta['hits'] ?? null;
        $this->aggregations = $meta['aggregations'] ?? [];

        return $this;
    }

    public function totalHits() : int
    {
        return Arr::get($this->hits, 'total.value');
    }

    public function maxScore(): float
    {
        return $this->hits['max_score'];
    }

    public function getShards()
    {
        return $this->shards;
    }

    public function getHits(): array
    {
        return $this->hits;
    }

    public function took(): string
    {
        return $this->took;
    }

    public function timedOut(): bool
    {
        return (bool) $this->timed_out;
    }

    public function getAggregations(): array
    {
        return $this->aggregations;
    }
}

