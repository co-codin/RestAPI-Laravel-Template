<?php


namespace Modules\Property\Http\Requests;


use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Property\Enums\PropertyType;

class PropertyCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'type' => [
                'required',
                new EnumValue(PropertyType::class, false)
            ],
            'options' => 'sometimes|nullable|string',
            'description' => 'sometimes|nullable|string',
            'is_hidden_from_product' => 'sometimes|boolean',
            'is_hidden_from_comparison' => 'sometimes|boolean',
            'categories' => 'required|array',
            'categories.*.id' => 'required|integer|distinct|exists:categories,id',
            'categories.*.position' => 'required|distinct|integer',
        ];
    }

    public function attributes()
    {
        return [
            'options' => 'Опции',
            'categories' => 'Категории',
            'categories.*.id' => 'ID Категории',
            'categories.*.position' => 'Позиция Категории',
        ];
    }
}
