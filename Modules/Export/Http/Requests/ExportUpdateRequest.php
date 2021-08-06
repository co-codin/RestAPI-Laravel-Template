<?php

namespace Modules\Export\Http\Requests;

use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Export\Enum\ExportFrequency;
use Modules\Export\Enum\ExportType;
use Modules\Product\Enums\ProductVariationStock;

class ExportUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'type' => [
                'sometimes',
                'required',
                'integer',
                new EnumValue(ExportType::class, false),
            ],
            'filename' => 'sometimes|required|string|max:255',
            'frequency' => [
                'sometimes',
                'required',
                'integer',
                new EnumValue(ExportFrequency::class, false),
            ],

            'parameters' => 'sometimes|required|array',

            'parameters.categories' => 'sometimes|required|array',
            'parameters.categories.ids' => 'sometimes|array',
            'parameters.categories.ids.*' => 'sometimes|integer|exists:categories,id',
            'parameters.categories.selected' => 'sometimes|bool',

            'parameters.brands' => 'sometimes|required|array',
            'parameters.brands.ids' => 'sometimes|array',
            'parameters.brands.ids.*' => 'sometimes|integer|exists:brands,id',
            'parameters.brands.selected' => 'sometimes|boolean',

            'parameters.products' => 'sometimes|required|array',
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
