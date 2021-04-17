<?php


namespace Modules\Property\Repositories;


use App\Repositories\BaseRepository;
use Modules\Property\Models\Property;
use Modules\Property\Repositories\Criteria\PropertyRequestCriteria;

class PropertyRepository extends BaseRepository
{
    public function model()
    {
        return Property::class;
    }

    public function boot()
    {
        $this->pushCriteria(PropertyRequestCriteria::class);
    }
}
