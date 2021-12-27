<?php


namespace Modules\Product\Repositories;


use App\Repositories\BaseRepository;
use Modules\Product\Models\VariationLink;
use Modules\Product\Repositories\Criteria\VariationLinkRequestCriteria;

/**
 * @property VariationLink $model
 */
class VariationLinkRepository extends BaseRepository
{
    public function model(): string
    {
        return VariationLink::class;
    }

    public function boot(): void
    {
        $this->pushCriteria(VariationLinkRequestCriteria::class);
    }
}
