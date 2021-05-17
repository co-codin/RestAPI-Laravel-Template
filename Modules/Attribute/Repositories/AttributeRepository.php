<?php


namespace Modules\Attribute\Repositories;


use App\Repositories\BaseRepository;
use Modules\Attribute\Models\Attribute;
use Modules\Attribute\Repositories\Criteria\AttributeRequestCriteria;

class AttributeRepository extends BaseRepository
{
    public function model()
    {
        return Attribute::class;
    }

    public function boot()
    {
        $this->pushCriteria(AttributeRequestCriteria::class);
    }
}
