<?php

namespace Modules\Filter\Entities\Types;

use Illuminate\Support\Arr;
use Modules\Search\Contracts\Aggregation as AggregationInterface;
use Modules\Search\Contracts\Filter as FilterInterface;
use Modules\Filter\Entities\Filter;
use Modules\Search\Filters\RangeFilter;
use Modules\Search\Aggregations\StatsAggregation;
use Parental\HasParent;

/**
 * Class SliderFilter
 * @package Modules\Filter\Entities\Types
 */
class SliderFilter extends Filter
{
    use HasParent;

    protected $pattern = '/^(from-(?<from>[0-9]+))?-?(to-(?<to>[0-9]+))?$/';

    public function validateValue($value = null) : bool
    {
        if(!preg_match($this->pattern, $value, $matches)) {
            return false;
        }

        return isset($matches['from'], $matches['to']) && $matches['to'] >= $matches['from'];
    }

    public function parseValue($value) : array
    {
        preg_match($this->pattern, $value, $matches);

        $matches = array_map('intval', $matches);

        $value = [];

        if(isset($matches["from"])) {
            $value['gte'] = $matches["from"];
        }

        if(isset($matches["to"])) {
            $value['lte'] = $matches["to"];
        }

        return $value;
    }

    public function getFilter(): FilterInterface
    {
        return new RangeFilter($this->field, $this->getSearchValue());
    }

    public function getAggregation() : AggregationInterface
    {
        return new StatsAggregation($this->slug, $this->field);
    }

    protected function getTagValue()
    {
        return implode(" - ", $this->value);
    }

    public function getUrlAttribute()
    {
        return $this->is_enabled && $this->value
            ? $this->slug . '-from-' . $this->value['gte'] . '-to-' . $this->value['lte']
            : null;
    }

    public function isNotEmpty() : bool
    {
        return ($this->aggregation['max'] ?? null) > ($this->aggregation['min'] ?? null);
    }

    protected function getSeoValue()
    {
        $label = Arr::get($this->options, 'seoTagLabel', "{$this->title}: от <from> и <to>");

        return str_replace(['<from>', '<to>'], $this->value, $label);
    }
}
