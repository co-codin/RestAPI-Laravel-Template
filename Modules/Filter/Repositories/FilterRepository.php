<?php


namespace Modules\Filter\Repositories;


use App\Repositories\BaseRepository;
use Modules\Filter\Models\Filter;
use Modules\Filter\Repositories\Criteria\FilterRequestCriteria;

class FilterRepository extends BaseRepository
{
    public function model()
    {
        return Filter::class;
    }

    public function boot()
    {
        $this->pushCriteria(FilterRequestCriteria::class);
    }

    public function findByCategoryId(int $category_id)
    {
        return $this->scopeQuery(function ($builder) use ($category_id) {
            return $builder
                ->where('category_id', $category_id)
                ->orderByRaw('-position DESC');
        })->get(['filters.*']);
    }

    public function findDefaultFilters()
    {
        return $this->scopeQuery(function ($builder) {
            return $builder->where('is_default', true);
        })->get(['filters.*']);
    }
}
