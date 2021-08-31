<?php


namespace Modules\Filter\Concerns;


use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Modules\Search\Contracts\Filter as FilterInterface;
use Modules\Search\Filters\NestedFilter;
use Modules\Search\Filters\PropertyFilter;
use Modules\Search\Filters\TermFilter;
use Modules\Search\Filters\TermsFilter;

/**
 * Trait Searchable
 * @package Modules\Filter\Concerns
 */
trait Searchable
{
    public function getFilter() : FilterInterface
    {
        return new TermsFilter($this->field, $this->getSearchValue());
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

//        if($propertyFilter = Arr::get($this->options, 'propertyFilter')) {
//            $filter = new PropertyFilter($this->path, $filter, $propertyFilter);
//        }

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
