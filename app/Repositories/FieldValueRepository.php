<?php


namespace App\Repositories;


use App\Models\FieldValue;
use App\Repositories\Criteria\FieldValueRequestCriteria;

class FieldValueRepository extends BaseRepository
{
    public function model()
    {
        return FieldValue::class;
    }

    public function boot()
    {
        $this->pushCriteria(FieldValueRequestCriteria::class);
    }
}
