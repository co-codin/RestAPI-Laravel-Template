<?php


namespace Modules\Product\Http\Requests\Admin;


use App\Http\Requests\BaseFormRequest;

class ProductPropertyUpdateRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'properties' => 'nullable|array',
            'properties.*.id' => 'required|distinct|integer|exists:properties,id',
            'properties.*.field_value_ids' => 'nullable|exists:field_values,id',
            'properties.*.pretty_key' => 'nullable|string|max:255',
            'properties.*.pretty_value' => 'nullable|string|max:255',
            'properties.*.is_important' => 'boolean',
            'properties.*.important_position' => 'nullable|integer',
            'properties.*.important_value' => 'required_if:properties.*.is_important,true|nullable|string|max:255',
        ];
    }
}
