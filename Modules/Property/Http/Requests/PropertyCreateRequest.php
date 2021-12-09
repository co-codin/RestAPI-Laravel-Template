<?php


namespace Modules\Property\Http\Requests;


use App\Http\Requests\BaseFormRequest;

class PropertyCreateRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'options' => 'sometimes|nullable|array',
            'description' => 'sometimes|nullable|string',
            'is_hidden_from_product' => 'sometimes|boolean',
            'is_hidden_from_comparison' => 'sometimes|boolean',
            'assigned_by_id' => 'sometimes|nullable|integer',
            'is_numeric' => 'sometimes|boolean',
            'is_boolean' => 'sometimes|boolean',
            'unit' => 'sometimes|nullable|string|max:50',
        ];
    }

    public function attributes()
    {
        return [
            'options' => 'Опции',
        ];
    }
}
