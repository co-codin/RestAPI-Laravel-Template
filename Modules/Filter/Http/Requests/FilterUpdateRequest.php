<?php

namespace Modules\Filter\Http\Requests;

use BenSampo\Enum\Rules\EnumValue;
use App\Http\Requests\BaseFormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Modules\Filter\Enums\FilterType;

class FilterUpdateRequest extends BaseFormRequest
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
            'slug' => [
                'required_with:category_id',
                'sometimes',
                'required',
                'string',
                'max:255',
                'regex:/^[a-z0-9_]+$/i',
                Rule::unique('filters')
                    ->where('category_id', $this->input('category_id'))
                    ->ignore($this->route('filter')),
            ],
            'type' => [
                'sometimes',
                'required',
                'integer',
                new EnumValue(FilterType::class, false)
            ],
            'category_id' => 'sometimes|integer|nullable|exists:categories,id',
            'is_default' => 'sometimes|boolean',
            'is_enabled' => 'sometimes|boolean',
            'description' => 'sometimes|nullable|string',
            'options' => 'sometimes|array',
            'unit' => 'sometimes|nullable|string|max:50',
            'is_system' => 'sometimes|required|boolean',

            // Facet
            'facet' => 'sometimes|required|array',
            'facet.property_id' => [ // обязательно только для пользовательских фильтров
                'exclude_unless:is_system,false',
                'required', 'integer', 'exists:properties,id',
            ],
            'facet.name' => [ // обязательно только для системных фильтров
                'exclude_unless:is_system,true',
                'required', 'string', 'max:255', 'regex:/^[a-z0-9_-]+$/i',
            ],
            'facet.path' => [ // обязательно только для системных фильтров
                'exclude_unless:is_system,true',
                'string', 'nullable', 'max:255', 'regex:/^[a-z0-9_-]+$/i',
            ],
            'facet.value' => [
                'exclude_unless:type,' . FilterType::CheckMark,
                'sometimes', 'required', 'integer', 'exists:field_values,id',
            ],

            // Options - SEO
            'options.seoPrefix' => [
                'exclude_unless:type,' . FilterType::CheckMarkList,
                'string',
                'nullable',
            ],
            'options.seoTagLabel' => [
                'exclude_unless:type,' . FilterType::Slider . ',' . FilterType::CheckMark,
                'string',
                'nullable',
                ($this->input("type") == FilterType::Slider ? "regex:<from>" : null),
                ($this->input("type") == FilterType::Slider ? "regex:<to>" : null),
            ],
            'options.seoTagLabels' => [
                'exclude_unless:type,' . FilterType::CheckMarkList,
                'array',
                'nullable',
            ],
            'options.seoTagLabels.*.key' => [
                'required',
                'integer',
                'exists:field_values,id',
            ],
            'options.seoTagLabels.*.value' => [
                'required',
                'string',
                'max:255',
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

    public function messages()
    {
        return [
            'options.seoTagLabel.regex' => 'Поле должно содержать переменные <from> и <to>',
        ];
    }
}
