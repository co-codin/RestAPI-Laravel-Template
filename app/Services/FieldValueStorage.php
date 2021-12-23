<?php


namespace App\Services;


use App\Models\FieldValue;

class FieldValueStorage
{
    public function store(array $data)
    {
        return FieldValue::query()->create($data);
    }

    public function update(FieldValue $fieldValue, array $data)
    {
        if (!$fieldValue->update($data)) {
            throw new \LogicException('can not update field value');
        }

        return $fieldValue;
    }
}
