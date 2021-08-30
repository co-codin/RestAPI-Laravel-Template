<?php

namespace Modules\Filter\Entities\Types;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\Search\Aggregations\BucketsAggregation;
use Modules\Search\Contracts\Aggregation as AggregationInterface;
use Modules\Search\Contracts\Filter as FilterInterface;
use Modules\Filter\Entities\Filter;
use Modules\Search\Filters\TermFilter;
use Parental\HasParent;

/**
 * Class CheckBoxFilter
 * @package Modules\Filter\Entities\Types
 */
class CheckMarkFilter extends Filter
{
    use HasParent;

    const DEFAULT_FILTER_VALUE = 1;

    public function getFilter() : FilterInterface
    {
        return new TermFilter($this->field, $this->getFilterValue());
    }

    public function getAggregation() : AggregationInterface
    {
        return new BucketsAggregation($this->slug, $this->field);
    }

    public function getTagAttribute()
    {
        return $this->is_enabled ? 'Да' : 'Нет';
    }

    public function getUrlAttribute()
    {
        return $this->is_enabled ? $this->slug : null;
    }

    public function getIsEnabledAttribute() : bool
    {
        return (isset($this->attributes['value']) && !! $this->attributes['value'])
            || $this->getParsedUrl()->has($this->slug);
    }

    public function getValueAttribute($value)
    {
        return !is_null($value)
            ? !! $value
            : $this->getParsedUrl()->has($this->slug);
    }

    protected function getFilterValue()
    {
        return Arr::get($this->options, 'filter_value') ?? static::DEFAULT_FILTER_VALUE;
    }

    public function isNotEmpty() : bool
    {
        return collect(Arr::get($this->aggregation, 'buckets'))
            ->pluck('key')
            ->contains($this->getFilterValue());
    }

    public function getSeoValue()
    {
        if($seoTagLabel = Arr::get($this->options, 'seoTagLabel')) {
            return $seoTagLabel;
        }

        return $this->title;
    }
}
