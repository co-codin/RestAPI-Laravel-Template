<?php


namespace Modules\Product\Http\Requests\Admin;


use BenSampo\Enum\Rules\EnumValue;
use App\Http\Requests\BaseFormRequest;
use Modules\Product\Enums\Availability;
use Modules\Product\Rules\ConfiguratorIsEnabledRule;

class ProductConfiguratorUpdateRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'variations' => 'required|array',
            'variations.*.id' => 'distinct|integer|exists:product_variations,id',
            'variations.*.name' => 'required|string|max:255',
            'variations.*.price' => 'required_if:variations.*.is_price_visible,true|nullable|numeric|gt:0',
            'variations.*.previous_price' => 'nullable|numeric|gt:0',
            'variations.*.currency_id' => 'required|integer|exists:currencies,id',
            'variations.*.condition_id' => 'required|integer|exists:field_values,id',
            'variations.*.is_price_visible' => 'boolean',
            'variations.*.is_enabled' => [
                'boolean',
                new ConfiguratorIsEnabledRule,
            ],
            'variations.*.availability' => [
                'required',
                'integer',
                new EnumValue(Availability::class, false),
            ],
            'variations.*.stock_type' => 'sometimes|nullable|string|max:255',

            // TODO incoming tasks
//            'options' => 'required|array',
//            'attributes' => 'required|array',
        ];
    }
}
