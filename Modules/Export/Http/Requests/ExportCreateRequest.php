<?php

namespace Modules\Export\Http\Requests;

use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Export\Enum\ExportFrequency;
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
            'frequency' => [
                'required',
                'integer',
                new EnumValue(ExportFrequency::class, false),
            ],
            'assigned_by_id' => 'sometimes|nullable|integer',

            'parameters' => 'sometimes|nullable|array',

            'parameters.categories' => 'sometimes|nullable|array',
            'parameters.categories.ids' => 'sometimes|nullable|array',
            'parameters.categories.ids.*' => 'sometimes|nullable|integer|exists:categories,id',
            'parameters.categories.selected' => 'sometimes|nullable|bool',

            'parameters.brands' => 'sometimes|nullable|array',
            'parameters.brands.ids' => 'sometimes|nullable|array',
            'parameters.brands.ids.*' => 'sometimes|nullable|integer|exists:brands,id',
            'parameters.brands.selected' => 'sometimes|nullable|boolean',

            'parameters.products' => 'sometimes|nullable|array',
            'parameters.products.ids' => 'sometimes|nullable|array',
            'parameters.products.ids.*' => 'sometimes|nullable|integer|exists:brands,id',
            'parameters.products.selected' => 'sometimes|nullable|boolean',

            'parameters.stock_type' => 'sometimes|nullable|string|max:255',

            'parameters.in_stock' => [
                'sometimes',
                'nullable',
                'integer',
                new EnumValue(ProductVariationStock::class, false),
            ],

            'parameters.short_description' => 'sometimes|nullable|boolean',

            'parameters.price' => 'sometimes|nullable|boolean'
        ];
    }
}
