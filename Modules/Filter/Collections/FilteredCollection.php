<?php


namespace Modules\Filter\Collections;


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

    /**
     * Set the result meta.
     *
     * @param array $meta
     * @return FilteredCollection
     */
    public function setMeta(array $meta)
    {
        $this->took = isset($meta['took']) ? $meta['took'] : null;
        $this->timed_out = isset($meta['timed_out']) ? $meta['timed_out'] : null;
        $this->shards = isset($meta['_shards']) ? $meta['_shards'] : null;
        $this->hits = isset($meta['hits']) ? $meta['hits'] : null;
        $this->aggregations = isset($meta['aggregations']) ? $meta['aggregations'] : [];

        return $this;
    }

    /**
     * Total Hits
     *
     * @return int
     */
    public function totalHits() : int
    {
        return Arr::get($this->hits, 'total.value');
    }

    /**
     * Max Score
     *
     * @return float
     */
    public function maxScore()
    {
        return $this->hits['max_score'];
    }

    /**
     * Get Shards
     *
     * @return array
     */
    public function getShards()
    {
        return $this->shards;
    }

    /**
     * Get Hits
     *
     * Get the raw hits array from
     * Elasticsearch results.
     *
     * @return array
     */
    public function getHits()
    {
        return $this->hits;
    }

    /**
     * Took
     *
     * @return string
     */
    public function took()
    {
        return $this->took;
    }

    /**
     * Timed Out
     *
     * @return bool
     */
    public function timedOut()
    {
        return (bool) $this->timed_out;
    }

    /**
     * Get aggregations
     *
     * Get the raw hits array from
     * Elasticsearch results.
     *
     * @return array
     */
    public function getAggregations()
    {
        return $this->aggregations;
    }
}
