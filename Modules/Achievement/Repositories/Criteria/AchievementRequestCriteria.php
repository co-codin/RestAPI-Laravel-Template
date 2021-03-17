<?php


namespace Modules\Achievement\Repositories\Criteria;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

class AchievementRequestCriteria implements CriteriaInterface
{
    protected array $data;

    protected array $allowedFilterFields = [
        'id', 'name', 'image', 'status',
    ];

    protected array $allowedSortFields = [
        'id', 'name', 'position',
    ];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $filters = array_intersect_key($this->data, array_flip($this->allowedFilterFields));
        $sorts = array_intersect_key($this->data['sortBy'], array_flip($this->allowedSortFields));

        $query = QueryBuilder::for($model)
            ->where($filters)
            ;

//        return QueryBuilder::for($model::query())
//            ->defaultSort('position')
//            ->allowedFilters([
//                AllowedFilter::exact('id'),
//                AllowedFilter::partial('name'),
//                AllowedFilter::exact('image_url'),
//                AllowedFilter::exact('status'),
//            ])
//            ->allowedSorts('id', 'name', 'position');
    }
}
