<?php


namespace Modules\Property\Http\Requests;


use App\Http\Requests\BaseFormRequest;

class PropertyUpdateRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'options' => 'sometimes|nullable|string',
            'description' => 'sometimes|nullable|string',
            'is_hidden_from_product' => 'sometimes|boolean',
            'is_hidden_from_comparison' => 'sometimes|boolean',
            'assigned_by_id' => 'sometimes|nullable|integer',
            'is_numeric' => 'sometimes|boolean',
            'is_multiple' => 'sometimes|boolean',
            'unit' => 'sometimes|string|max:255',
        ];
    }

    public function attributes()
    {
        return [
            'options' => 'Опции',
        ];
    }
}
