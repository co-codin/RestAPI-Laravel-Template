<?php


namespace Modules\Filter\Concerns;


use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Modules\Filter\Contracts\FilterInterface;
use Modules\Filter\Enums\FilterType;
use Modules\Filter\Filters\NestedFilter;
use Modules\Filter\Filters\PropertyFilter;
use Modules\Filter\Filters\TermFilter;
use Modules\Filter\Filters\TermsFilter;

trait Searchable
{
    public function getFilter() : FilterInterface
    {
        if ($this->property_id !== null && $this->type !== FilterType::Slider) {
            return new TermsFilter('properties.slug', $this->getSearchValue());
        }
        if ($this->property_id !== null && $this->type === FilterType::Slider) {
            return new TermsFilter('properties.slug_number', $this->getSearchValue());
        }
    }

    /**
     * @return array|Collection
     */
    public function toFilter() : array
    {
        $filter = $this->getFilter();

        if($property_id = Arr::get($this->options, 'property_id')) {
            $propertyFilter = (new TermFilter($this->path . '.key', $property_id))->toFilter();
            $filter = new PropertyFilter($this->path, $filter, $propertyFilter);
        }

        if($this->path) {
            $path = explode(".", $this->path);
            for ($i = count($path); $i > 0; $i--) {
                $filter = new NestedFilter(implode('.', array_slice($path, 0, $i)), [$filter]);
            }
        }

        return $filter->toFilter();
    }

    protected function getSearchValue()
    {
        $value = $this->value;

        if($searchFormatter = Arr::get($this->options, 'searchFormatter')) {
            $value = app($searchFormatter)->format($value);
        }

        return $value;
    }
}
