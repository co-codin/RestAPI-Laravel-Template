<?php


namespace Modules\Product\Http\Requests;


use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Product\Enums\ProductVariationStock;

class ProductConfiguratorUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'variations' => 'required|array',
            'variations.*.id' => 'sometimes|distinct|integer|exists:product_variations,id',
            'variations.*.name' => 'required|string|max:255',
            'variations.*.price' => 'sometimes|nullable|numeric|gt:0',
            'variations.*.previous_price' => 'sometimes|nullable|numeric|gt:0',
            'variations.*.currency_id' => 'sometimes|nullable|integer|exists:currencies,id',
            'variations.*.is_price_visible' => 'required|boolean',
            'variations.*.is_enabled' => 'required|boolean',
            'variations.*.availability' => [
                'required',
                'integer',
                new EnumValue(ProductVariationStock::class, false),
            ],
            'variations.*.stock_type' => 'sometimes|nullable|string|max:255',

            // TODO incoming tasks
//            'options' => 'required|array',
//            'attributes' => 'required|array',
        ];
    }
}
