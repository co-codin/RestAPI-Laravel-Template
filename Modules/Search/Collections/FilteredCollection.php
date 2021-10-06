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
        $this->aggregations = $this->parseAggregations($meta['aggregations'] ?? []);

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

    protected function parseAggregations($aggregations): array
    {
        $facets = [
            "facets",
            "variations_facets",
            "variations_numeric_facets",
        ];

        return collect($facets)
            ->map(fn($facet) => collect(Arr::get($aggregations, $facet . ".names.buckets")))
            ->map(fn($collection) => $collection->pluck('values', 'key'))
            ->map(function($collection) {
                return $collection->map(function($value, $name) {
                    if(!Arr::exists($value, 'buckets')) {
                        return $value;
                    }

                    $value['buckets'] = array_map(function($bucket) {
                        $exploded = explode("|||", $bucket['key']);
                        $bucket['key'] = $exploded[0];
                        $bucket['label'] = $exploded[1];
                        return $bucket;
                    }, $value['buckets']);

                    return $value;
                });
            })
            ->collapse()
            ->toArray();
    }
}

