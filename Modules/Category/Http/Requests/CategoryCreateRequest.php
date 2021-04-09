<?php

namespace Modules\Category\Http\Requests;

use App\Enums\Status;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryCreateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'parent_id' => 'sometimes|nullable|integer|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'product_name' => 'sometimes|nullable|string|max:255',
            'full_description' => 'sometimes|nullable|string',
            'status' => [
                'required',
                new EnumValue(Status::class, false),
            ],
            'is_hidden_in_parents' => 'sometimes|boolean',
            'is_in_home' => 'sometimes|boolean',
            'image' => [
                Rule::requiredIf(function() {
                    return !$this->input('parent_id');
                }),
                'nullable',
                'string',
                'max:255',
            ],
            'short_properties' => 'sometimes|nullable|array',
            'short_properties.*' => 'required|int',
//            'short_properties.*' => 'required|int|exists:properties,id',
        ];
    }
}
