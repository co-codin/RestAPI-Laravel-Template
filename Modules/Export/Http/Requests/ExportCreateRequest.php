<?php

namespace Modules\Export\Http\Requests;

use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Export\Enum\ExportType;
use Modules\Product\Enums\ProductVariationStock;

class ExportCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'type' => [
                'required',
                'integer',
                new EnumValue(ExportType::class, false),
            ],
            'filename' => 'required|string|max:255',
            'frequency' => 'required|integer',

            'parameters' => 'sometimes|array',

            'parameters.categories' => 'sometimes|array',
            'parameters.categories.ids' => 'sometimes|array',
            'parameters.categories.ids.*' => 'sometimes|integer|exists:categories,id',
            'parameters.categories.selected' => 'sometimes|bool',

            'parameters.brands' => 'sometimes|array',
            'parameters.brands.ids' => 'sometimes|array',
            'parameters.brands.ids.*' => 'sometimes|integer|exists:brands,id',
            'parameters.brands.selected' => 'sometimes|boolean',

            'parameters.products' => 'sometimes|array',
            'parameters.products.ids' => 'sometimes|array',
            'parameters.products.ids.*' => 'sometimes|integer|exists:brands,id',
            'parameters.products.selected' => 'sometimes|boolean',

            'parameters.stock_type' => 'sometimes|string|max:255',

            'parameters.in_stock' => [
                'sometimes',
                'integer',
                new EnumValue(ProductVariationStock::class, false),
            ],

            'parameters.short_description' => 'sometimes|boolean',

            'parameters.price' => 'sometimes|boolean'
        ];
    }
}
