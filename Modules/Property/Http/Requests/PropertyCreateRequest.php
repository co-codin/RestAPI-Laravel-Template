<?php


namespace Modules\Property\Http\Requests;


use BenSampo\Enum\Rules\EnumValue;
use App\Http\Requests\BaseFormRequest;
use Modules\Property\Enums\PropertyType;

class PropertyCreateRequest extends BaseFormRequest
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
            'options' => 'sometimes|nullable|array',
            'description' => 'sometimes|nullable|string',
            'is_hidden_from_product' => 'sometimes|boolean',
            'is_hidden_from_comparison' => 'sometimes|boolean',
            'assigned_by_id' => 'sometimes|nullable|integer',
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
