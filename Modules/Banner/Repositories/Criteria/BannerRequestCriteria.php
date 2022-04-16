<?php

namespace Modules\Banner\Repositories\Criteria;

use App\Http\Filters\LiveFilter;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class BannerRequestCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return QueryBuilder::for($model)
            ->defaultSort('id')
            ->allowedFields(array_merge(
                static::allowedBannerFields(),
            ))
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::exact('page'),
                AllowedFilter::partial('url'),
                AllowedFilter::exact('position'),
                AllowedFilter::exact('is_enabled'),
                AllowedFilter::custom('live', new LiveFilter([
                    'id' => '=',
                    'name' => 'like',
                    'url' => 'like',
                ])),
                AllowedFilter::trashed(),
            ])
            ->allowedSorts([
                'id',
                'name',
                'url',
                'position',
                'is_enabled',
                'created_at',
                'updated_at',
                'deleted_at',
            ]);
    }

    public static function allowedBannerFields($prefix = null): array
    {
        $fields = [
            'id',
            'name',
            'url',
            'position',
            'is_enabled',
            'created_at',
            'updated_at',
            'deleted_at',
        ];

        if(!$prefix) {
            return $fields;
        }

        return array_map(fn($field) => $prefix . "." . $field, $fields);
    }
}
