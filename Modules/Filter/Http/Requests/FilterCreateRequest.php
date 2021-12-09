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
        $rules = [
            'name' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-z0-9_]+$/i',
                Rule::unique('filters')
                    ->where('category_id', $this->category_id)
            ],
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
            'unit' => 'sometimes|nullable|string|max:50',
            'facet' => 'required|array',
            'facet.name' => 'required_unless:property_id|string',
            'facet.path' => 'required|string',
            'facet.value' => 'required_if:type,' . FilterType::CheckMark . '|nullable|string',
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
