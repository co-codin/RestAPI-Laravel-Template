<?php


namespace Modules\Vacancy\Repositories\Criteria;


use App\Http\Filters\LiveFilter;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class VacancyRequestCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return QueryBuilder::for($model)
            ->defaultSort('-id')
            ->allowedFields([
                'id', 'name', 'slug', 'short_description', 'status',
                'duty', 'requirement', 'condition',
                'experience', 'timetable', 'occupation', 'created_at', 'updated_at',
            ])
            ->allowedFilters([
                AllowedFilter::custom('live', new LiveFilter([
                    'id' => '=',
                    'name' => 'like',
                    'slug' => '=',
                ])),
                AllowedFilter::exact('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::exact('slug'),
                AllowedFilter::partial('short_description'),
                AllowedFilter::exact('status'),
            ])
            ->allowedSorts('id', 'name', 'slug', 'short_description', 'full_description', 'status', 'created_at', 'updated_at')
            ;
    }
}
