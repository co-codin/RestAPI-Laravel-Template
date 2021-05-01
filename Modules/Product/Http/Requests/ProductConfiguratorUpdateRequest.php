<?php


namespace Modules\Product\Http\Requests;


use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Product\Enums\ProductVariantStock;

class ProductConfiguratorUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'variants' => 'required|array',
            'variants.*.id' => 'sometimes|distinct|integer|exists:product_variants,id',
            'variants.*.name' => 'required|string|max:255',
            'variants.*.price' => 'sometimes|nullable|numeric|gt:0',
            'variants.*.previous_price' => 'sometimes|nullable|numeric|gt:0',
            'variants.*.currency_id' => 'sometimes|nullable|integer|exists:currencies,id',
            'variants.*.is_price_visible' => 'required|boolean',
            'variants.*.is_enabled' => 'required|boolean',
            'variants.*.availability' => [
                'required',
                'integer',
                new EnumValue(ProductVariantStock::class, false),
            ],
            'variants.*.stock_type' => 'sometimes|nullable|string|max:255',

            // TODO incoming tasks
//            'options' => 'required|array',
//            'attributes' => 'required|array',
        ];
    }
}
