<?php


namespace Modules\Seo\Repositories\Admin;


use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Collection as SupportCollection;
use Modules\Seo\Models\CanonicalEntity;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\QueryBuilder as SpatieQueryBuilder;

/**
 * Class CanonicalRepository
 * @package Modules\Seo\Repositories\Admin
 * @property CanonicalEntity $model
 */
class CanonicalRepository extends BaseRepository implements CanonicalRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CanonicalEntity::class;
    }
}
