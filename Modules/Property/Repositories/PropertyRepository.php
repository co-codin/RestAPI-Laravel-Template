<?php


namespace Modules\Property\Repositories;


use App\Repositories\BaseRepository;
use Modules\Property\Models\Property;

class PropertyRepository extends BaseRepository
{
    public function model()
    {
        return Property::class;
    }

    public function boot()
    {

    }
}
