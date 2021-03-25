<?php


namespace Modules\Brand\Repositories;

use App\Repositories\BaseRepository;
use App\Repositories\Criteria\ActiveStatusCriteria;
use App\Repositories\Criteria\NoInactiveCriteria;
use Modules\Brand\Models\Brand;
use Modules\Brand\Repositories\Criteria\BrandRequestCriteria;

class BrandRepository extends BaseRepository
{
    public function model()
    {
        return Brand::class;
    }

    public function boot()
    {
        $this->pushCriteria(ActiveStatusCriteria::class);
        $this->pushCriteria(BrandRequestCriteria::class);
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
