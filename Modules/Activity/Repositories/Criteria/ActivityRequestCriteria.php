<?php

namespace Modules\Activity\Repositories\Criteria;

use App\Http\Filters\LiveFilter;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ActivityRequestCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return QueryBuilder::for($model)
            ->defaultSort('-id')
            ->allowedFields(array_merge(
                static::allowedActivityFields(),
            ))
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::custom('live', new LiveFilter([
                    'id' => '=',
                ])),
            ])
            ->allowedIncludes([
                'causer',
                'subject',
                'parentSubject',
            ])
            ->allowedSorts([
                'id',
                'log_name',
                'description',
                'subject_type',
                'subject_id',
                'event',
                'causer_type',
                'causer_id',
                'created_at',
                'updated_at',
            ]);
    }

    public static function allowedActivityFields($prefix = null): array
    {
        $fields = [
            'id',
            'log_name',
            'description',
            'subject_type',
            'subject_id',
            'event',
            'causer_type',
            'causer_id',
            'properties',
            'created_at',
            'updated_at',
        ];

        if(!$prefix) {
            return $fields;
        }

        return array_map(fn($field) => $prefix . "." . $field, $fields);
    }
}
