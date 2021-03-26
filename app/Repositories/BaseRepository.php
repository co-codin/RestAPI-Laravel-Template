<?php

namespace App\Repositories;

use App\Repositories\Criteria\ActiveStatusCriteria;
use App\Repositories\Criteria\NoInactiveCriteria;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseRepository
 * @method jsonPaginate()
 */
class BaseRepository extends \Prettus\Repository\Eloquent\BaseRepository
{
    public function model()
    {
        return Model::class;
    }

    public function findBySlug(string $slug)
    {
        return $this
            ->popCriteria(ActiveStatusCriteria::class)
            ->pushCriteria(NoInactiveCriteria::class)
            ->scopeQuery(fn($q) => $q->where('slug', $slug))
            ->first();
    }
}
