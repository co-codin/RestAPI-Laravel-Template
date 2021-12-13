<?php

namespace Modules\Filter\Http\Requests;

use BenSampo\Enum\Rules\EnumValue;
use App\Http\Requests\BaseFormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Modules\Filter\Enums\FilterType;

class FilterCreateRequest extends BaseFormRequest
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
            'slug' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-z0-9_]+$/i',
                Rule::unique('filters')
                    ->where('category_id', $this->input('category_id'))
            ],
            'is_system' => 'required|boolean',
            'type' => [
                'required',
                'integer',
                new EnumValue(FilterType::class, false)
            ],
            'category_id' => 'integer|nullable|exists:categories,id',
            'is_default' => 'boolean',
            'is_enabled' => 'boolean',
            'description' => 'nullable|string',
            'unit' => 'nullable|string|max:50',

            // Facet
            'facet' => 'required|array',
            'facet.property_id' => [ // обязательно только для пользовательских фильтров
                'exclude_unless:is_system,false',
                'required', 'integer', 'exists:properties,id',
            ],
            'facet.name' => [ // обязательно только для системных фильтров
                'exclude_unless:is_system,true',
                'required', 'string', 'max:255', 'regex:/^[a-z0-9_-\.]+$/i',
            ],
            'facet.path' => [ // обязательно только для системных фильтров
                'exclude_unless:is_system,true',
                'string', 'nullable', 'max:255', 'regex:/^[a-z0-9_-]+$/i',
            ],
            'facet.value' => [
                'exclude_unless:type,' . FilterType::CheckMark,
                'required', 'integer', 'exists:field_values,id',
            ],
        ];
    }

    public function attributes()
    {
        return [
            'type' => 'Метод отображения',
            'category_id' => 'Категория',
            'is_system' => 'Тип',
            'facet.property_id' => 'Характеристика',
            'facet.name' => 'Системное поле',
            'facet.value' => 'Значение для поиска',
            'facet.path' => 'Путь к системному полю',
        ];
    }
}
