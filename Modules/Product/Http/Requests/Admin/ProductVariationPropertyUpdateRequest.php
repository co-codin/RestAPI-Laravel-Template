<?php

namespace Modules\Product\Http\Requests\Admin;

use App\Http\Requests\BaseFormRequest;

class ProductVariationPropertyUpdateRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'property_id' => 'required|integer|exists:properties,id',
            'product_variation_id' => 'required|integer|exists:product_variations,id',
            'field_value_ids' => 'nullable|exists:field_values,id',
        ];
    }
}
