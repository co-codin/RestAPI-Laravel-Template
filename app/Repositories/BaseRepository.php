<?php

namespace App\Repositories;

use App\Repositories\Criteria\ActiveStatusCriteria;
use App\Repositories\Criteria\NoInactiveCriteria;

/**
 * Class BaseRepository
 * @method jsonPaginate()
 */
abstract class BaseRepository extends \Prettus\Repository\Eloquent\BaseRepository
{
    public function findBySlug(string $slug)
    {
        return $this
            ->popCriteria(ActiveStatusCriteria::class)
            ->pushCriteria(NoInactiveCriteria::class)
            ->scopeQuery(fn($q) => $q->where('slug', $slug))
            ->first();
    }
}
