<?php


namespace App\Services;


use App\Models\FieldValue;

class FieldValueDestroyService
{
    public function delete(FieldValue $fieldValue): void
    {
//        $this->checkValueInProductProperties($fieldValue->id);
//        $this->checkValueInBrands($fieldValue->id);
//        $this->checkValueInProductStockType($fieldValue->id);
//        $this->checkValueInProductVariationCondition($fieldValue->id);
        $this->checkValueInFilterOptions($fieldValue->id);
        throw new \LogicException('can not delete field value');

        if (!$fieldValue->delete()) {
            throw new \LogicException('can not delete field value');
        }
    }

    private function checkValueInProductProperties(int $id): void
    {
        $inProductProperties = \DB::table('product_property')
            ->whereRaw("JSON_CONTAINS(field_value_ids, '?', '$')", [$id])
            ->exists();

        if (!$inProductProperties) {
            return;
        }

        throw new \LogicException("Вы не можете удалить это значение, так как оно используется в характеристиках");
    }

    private function checkValueInBrands(int $id): void
    {
        $inBrandCountryId = \DB::table('brands')
            ->where('country_id', $id)
            ->exists();

        if ($inBrandCountryId) {
            throw new \LogicException('Вы не можете удалить это значение, т.к. оно используется у производителя');
        }
    }

    private function checkValueInProductStockType(int $id): void
    {
        $inStockTypeId = \DB::table('products')
            ->where('stock_type_id', $id)
            ->exists();

        if ($inStockTypeId) {
            throw new \LogicException('Вы не можете удалить это значение, т.к. оно используется у товаров');
        }
    }

    private function checkValueInProductVariationCondition(int $id): void
    {
        $inConditionId = \DB::table('product_variations')
            ->where('condition_id', $id)
            ->exists();

        if ($inConditionId) {
            throw new \LogicException('Вы не можете удалить это значение, т.к. оно используется у вариаций товаров');
        }
    }

    private function checkValueInFilterOptions(int $id): void
    {
        $inOptions = \DB::table('filters')
            ->where('options->seoTagLabels->key', $id)
            ->orWhere('options->seoTagLabels->key', "$id")
//            ->whereJsonContains('options->seoTagLabels->key', $id)
            ->exists();

        if ($inOptions) {
            throw new \LogicException('Вы не можете удалить это значение, т.к. оно используется в опциях у фильтров');
        }
    }
}
