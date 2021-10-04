<?php


namespace App\Repositories;


use App\Models\FieldValue;

class FieldValueRepository extends BaseRepository
{
    public function model()
    {
        return FieldValue::class;
    }
}
