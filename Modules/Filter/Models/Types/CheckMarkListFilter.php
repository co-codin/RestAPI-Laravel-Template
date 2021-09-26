<?php


namespace Modules\Filter\Models\Types;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\Property\Entities\PropertyValue;
use Modules\Search\Aggregations\BucketsAggregation;
use Modules\Search\Contracts\Aggregation;
use Modules\Search\Contracts\Filter as FilterInterface;
use Modules\Filter\Models\Filter;
use Modules\Search\Filters\TermsFilter;
use Parental\HasParent;

/**
 * Class CheckBoxListFilter
 * @package Modules\Filter\Entities\Types
 * @property array $property
 */
class CheckMarkListFilter extends Filter
{
    use HasParent;

    const MULTI_VALUE_AGGREGATION_FIELD = 'aggregation';
    const AGGREGATION_SLUG_FIELD = 'slug';
    const AGGREGATION_TITLE_FIELD = 'title';
    const SEO_MULTI_VALUE_DELIMITER = ", ";
    const SEO_PREFIX_AFTER = ": ";

    public function isNotEmpty() : bool
    {
        return $this->aggregation->isNotEmpty();
    }

    public function validateValue($value): bool
    {
        return preg_match('/^[a-z0-9_-]+$/', $value);
    }

    public function parseValue($value)
    {
        return array_filter($value);
    }

    public function getFilter() : FilterInterface
    {
        return new TermsFilter($this->field, $this->value);
    }

    public function getAggregationAttribute($value)
    {
        if (!is_null($this->bucket_position)) {
            $bucket_positions = collect(json_decode($this->bucket_position, true));

            return $value->sort()->sortBy(function ($agg, $key) use ($bucket_positions) {
                return $bucket_positions->get($key, INF);
            });
        } else {
            return $value->sort();
        }
    }

    public function getAggregation() : Aggregation
    {
        $fieldPrefix = collect(explode('.', $this->field))->slice(0, -1)->implode('.');

        if(Arr::get($this->options, 'property_id')) {
            return new BucketsAggregation(
                $this->slug,
                ($fieldPrefix ? $fieldPrefix . "." : null) . self::MULTI_VALUE_AGGREGATION_FIELD
            );
        }

        $defaultSlugField = ($fieldPrefix ? $fieldPrefix . '.' : '') . static::AGGREGATION_SLUG_FIELD;
        $defaultTitleField = ($fieldPrefix ? $fieldPrefix . '.' : '') . static::AGGREGATION_TITLE_FIELD;

        $slugField = Arr::get($this->options, 'aggregation.slugField', $defaultSlugField);
        $titleField = Arr::get($this->options, 'aggregation.titleField', $defaultTitleField);

        return new BucketsAggregation(
            $this->slug,
            "doc['{$slugField}'].value + '" . PropertyValue::AGGREGATION_ROW_DELIMITER . "' + doc['{$titleField}'].value",
            'script'
        );
    }

    public function fillAggregation($aggregation)
    {
        $aggregation = collect(Arr::get($aggregation, 'buckets'))
            ->mapWithKeys(function($item) {
                $value = explode(PropertyValue::AGGREGATION_ROW_DELIMITER, $item['key']);
                return [$value[0] => $value[1]];
            });

        parent::fillAggregation($aggregation);
    }

    public function getTagValue($glue = ", ")
    {
        if(!$this->aggregation) {
            return null;
        }

        $values = array_intersect_key($this->aggregation->toArray(),
            array_flip(Arr::wrap($this->value)));

        return implode($glue, Arr::sort($values));
    }

    public function getUrlAttribute()
    {
        return $this->is_enabled && $this->value
            ? $this->slug . '-' . implode("-or-", (array) $this->value)
            : null;
    }

    public function isSelected($key)
    {
        return in_array($key, Arr::wrap($this->value));
    }

    protected function getSeoValue()
    {
        if($seoTagLabels = Arr::get($this->options, 'seoTagLabels')) {
            $seoTagLabels = Arr::pluck($seoTagLabels, 'value', 'key');
            $values = array_intersect_key($seoTagLabels,
                array_flip(Arr::wrap($this->value)));

            return $this->getSeoValuePrefix() . Str::lower(implode(static::SEO_MULTI_VALUE_DELIMITER, $values));
        }

        return $this->getSeoValuePrefix() . $this->getTagValue(static::SEO_MULTI_VALUE_DELIMITER);
    }

    protected function getSeoValuePrefix(): ?string
    {
        if(!$seo_prefix = Arr::get($this->options, 'seoPrefix')) {
            return null;
        }

        return $seo_prefix . static::SEO_PREFIX_AFTER;
    }
}
