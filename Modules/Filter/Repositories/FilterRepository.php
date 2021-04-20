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
}
