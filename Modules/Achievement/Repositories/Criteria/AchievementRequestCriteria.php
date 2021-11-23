<?php


namespace Modules\Achievement\Repositories\Criteria;

use App\Http\Filters\LiveFilter;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class AchievementRequestCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return QueryBuilder::for($model)
            ->defaultSort('position')
            ->allowedFields(['id', 'name', 'image', 'position', 'is_enabled', 'created_at', 'updated_at'])
            ->allowedFilters([
                AllowedFilter::custom('live', new LiveFilter([
                    'id' => '=',
                    'name' => 'like',
                ])),
                AllowedFilter::exact('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::exact('image'),
                AllowedFilter::exact('is_enabled'),
            ])
            ->allowedSorts('id', 'name', 'image', 'position', 'is_enabled', 'created_at', 'updated_at')
            ;
    }
}
