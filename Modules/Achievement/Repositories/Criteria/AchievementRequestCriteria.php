<?php


namespace Modules\Achievement\Repositories\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
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
        dd(
            $this->data
        );
        $query = QueryBuilder::for($model::query());

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
