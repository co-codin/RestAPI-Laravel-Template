<?php


namespace Modules\Product\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class ProductPropertyUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'properties' => 'required|array',
            'properties.*.id' => 'required|distinct|integer|exists:properties,id',
            'properties.*.value' => 'sometimes|array',
            'properties.*.pretty_key' => 'sometimes|string|max:255',
            'properties.*.pretty_value' => 'sometimes|string|max:255',
            'properties.*.is_important' => 'sometimes|boolean',
            'properties.*.important_position' => 'sometimes|nullable|integer',
            'properties.*.important_value' => 'sometimes|string|max:255',
        ];
    }
}