<?php


namespace Modules\Export\Http\Requests;


use BenSampo\Enum\Rules\EnumValue;
use Modules\Product\Enums\Availability;

trait ExportFilterRequest
{
    public function rules(): array
    {
        return [
            'filter' => 'sometimes|nullable|array',

            'filter.category' => 'sometimes|nullable|array',
            'filter.category.ids' => 'sometimes|nullable|array',
            'filter.category.ids.*' => 'sometimes|nullable|integer|exists:categories,id',
            'filter.category.selected' => 'required_with:filter.category.ids|sometimes|nullable|bool',

            'filter.brand' => 'sometimes|nullable|array',
            'filter.brand.ids' => 'sometimes|nullable|array',
            'filter.brand.ids.*' => 'sometimes|nullable|integer|exists:brands,id',
            'filter.brand.selected' => 'sometimes|nullable|boolean',

            'filter.product' => 'sometimes|nullable|array',
            'filter.product.ids' => 'sometimes|nullable|array',
            'filter.product.ids.*' => 'sometimes|nullable|integer|exists:products,id',
            'filter.product.selected' => 'required_with:filter.product.ids|nullable|boolean',

            'filter.stock_type' => 'sometimes|nullable|array',
            'filter.stock_type.ids' => 'sometimes|nullable|array',
            'filter.stock_type.ids.*' => 'sometimes|nullable|integer|exists:field_values,id',
            'filter.stock_type.selected' => 'sometimes|nullable|boolean',

            'filter.availability' => 'sometimes|nullable|array',
            'filter.availability.ids' => 'sometimes|nullable|array',
            'filter.availability.ids.*' => [
                'required',
                'integer',
                new EnumValue(Availability::class, false),
            ],
            'filter.availability.selected' => 'sometimes|nullable|boolean',

            'filter.has_short_description' => 'sometimes|nullable|boolean',
            'filter.has_price' => 'sometimes|nullable|boolean',
            'filter.is_price_visible' => 'sometimes|nullable|boolean',
            'filter.max_price' => 'sometimes|nullable|numeric|gt:filter.min_price',
            'filter.min_price' => 'sometimes|nullable|numeric|lt:filter.max_price',
        ];
    }
}
