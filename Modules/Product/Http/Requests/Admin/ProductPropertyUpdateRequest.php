<?php


namespace Modules\Product\Http\Requests\Admin;


use App\Http\Requests\BaseFormRequest;

class ProductPropertyUpdateRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'properties' => 'required|array',
            'properties.*.id' => 'required|distinct|integer|exists:properties,id',
            'properties.*.value' => 'sometimes|nullable',
            'properties.*.pretty_key' => 'sometimes|nullable|string|max:255',
            'properties.*.pretty_value' => 'sometimes|nullable|string|max:255',
            'properties.*.is_important' => 'sometimes|boolean',
            'properties.*.important_position' => 'sometimes|nullable|integer',
            'properties.*.important_value' => 'sometimes|nullable|string|max:255',
        ];
    }
}
