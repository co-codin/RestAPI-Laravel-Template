<?php

namespace Modules\Filter\Http\Requests;

use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Modules\Filter\Enums\FilterType;

class FilterCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|regex:/^[a-z0-9_]+$/i',
            'property_id' => 'required|integer|exists:properties,id',
            'type' => [
                'required',
                'integer',
                new EnumValue(FilterType::class, false)
            ],
            'category_id' => 'required|integer|exists:categories,id',
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
