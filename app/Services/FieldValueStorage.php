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

    public function delete(FieldValue $fieldValue)
    {
        $this->checkValueInProductProperties($fieldValue->id);

        if (!$fieldValue->delete()) {
            throw new \LogicException('can not delete field value');
        }
    }

    protected function checkValueInProductProperties($id)
    {
        $inProductProperties = \DB::table('product_property')
            ->whereRaw("JSON_CONTAINS(field_value_ids, '?', '$')", [$id])
            ->exists();

        if(!$inProductProperties) {
            return;
        }

        throw new \LogicException("Вы не можете удалить это значение, так как оно используется в характеристиках");
    }
}
