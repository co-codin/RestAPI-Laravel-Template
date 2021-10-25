<?php


namespace App\Services;


use App\Models\FieldValue;

class FieldValueStorage
{
    public function store(array $data)
    {
        return FieldValue::query()->create($data);
    }
}
