<?php

namespace Modules\Filter\Http\Requests;

use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
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
            'slug' => [
                'required_with:category_id',
                'string',
                'max:255',
                'regex:/^[a-z0-9_]+$/i',
                Rule::unique('filters')
                    ->ignore($this->filter)
                    ->where('category_id', $this->category_id)
            ],
            'property_id' => 'sometimes|required|integer|exists:properties,id',
            'type' => [
                'sometimes',
                'required',
                'integer',
                new EnumValue(FilterType::class, false)
            ],
            'category_id' => 'sometimes|required|integer|exists:categories,id|required_with:slug',
            'is_default' => 'sometimes|boolean',
            'is_enabled' => 'sometimes|boolean',
            'description' => 'sometimes|nullable|string',
            'options' => 'sometimes|array',
        ];

        if(($type = $this->input('type')) && $fields = Arr::get(FilterType::fields(), $type)) {
            foreach ($fields as $item) {
                if($item['rules'] ?? null) {
                    $rules["options.{$item['name']}"] = $item['rules'];
                }
            }
        }

        return $rules;
    }
}
