<?php


namespace Modules\Property\Http\Requests;


use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Property\Enums\PropertyType;

class PropertyUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'type' => [
                'sometimes',
                'required',
                new EnumValue(PropertyType::class, false)
            ],
            'options' => 'sometimes|nullable|string',
            'description' => 'sometimes|nullable|string',
            'is_hidden_from_product' => 'sometimes|boolean',
            'is_hidden_from_comparison' => 'sometimes|boolean',
            'categories' => 'sometimes|required|array',
            'categories.*.id' => 'sometimes|required|integer|exists:categories,id',
            'categories.*.position' => 'sometimes|required|distinct|integer',
        ];
    }

    public function attributes()
    {
        return [
            'options' => 'Опции',
            'categories' => 'Категории',
        ];
    }
}
