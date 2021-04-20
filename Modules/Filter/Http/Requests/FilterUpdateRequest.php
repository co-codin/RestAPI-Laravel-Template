<?php

namespace Modules\Filter\Http\Requests;

use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Modules\Filter\Enums\FilterType;

class FilterUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|required|string|max:255|regex:/^[a-z0-9_]+$/i|unique:filters,slug,' . $this->route('filter'),
            'property_id' => 'sometimes|required|integer|exists:properties,id',
            'type' => [
                'sometimes',
                'required',
                'integer',
                new EnumValue(FilterType::class, false)
            ],
            'category_id' => 'sometimes|required|integer|exists:categories,id',
            'is_default' => 'sometimes|boolean',
            'is_enabled' => 'sometimes|boolean',
            'description' => 'sometimes|nullable|string',
            'options' => 'sometimes|array',
        ];

        if(($type = $this->input('type')) && $fields = Arr::get(FilterType::fields(), $type)) {
            foreach ($fields as $item) {
                if($item['rules'] ?? null) {
                    $rules["options.{$item['name']}"] = !empty($item['rules']) ? 'sometimes|' . $item['rules'] : $item['rules'];
                }
            }
        }

        return $rules;
    }
}
