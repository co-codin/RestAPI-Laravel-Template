<?php

namespace Modules\Category\Http\Requests;

use App\Enums\Status;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class CategoryUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'parent_id' => 'sometimes|nullable|integer|exists:categories,id',
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|nullable|string|max:255|unique:categories,slug,' . $this->route('category'),
            'product_name' => 'sometimes|nullable|string|max:255',
            'full_description' => 'sometimes|nullable|string',
            'status' => [
                'sometimes',
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

    protected function passedValidation()
    {
        abort_if(!$this->validated(), Response::HTTP_BAD_REQUEST);
    }
}