<?php

namespace Modules\Category\Http\Requests;

use App\Enums\Status;
use App\Http\RequestFilters\SanitizesInput;
use BenSampo\Enum\Rules\EnumValue;
use App\Http\Requests\BaseFormRequest;

class CategoryUpdateRequest extends BaseFormRequest
{
    use SanitizesInput;

    public function filters(): array
    {
        return [
            'parent_id' => 'nullable-cast:int',
            'status' => 'nullable-cast:int',
            'is_in_home' => 'nullable-cast:bool',
            'is_image_changed' => 'nullable-cast:bool',
            'assigned_by_id' => 'nullable-cast:int',
        ];
    }

    public function rules()
    {
        return [
            'parent_id' => 'sometimes|nullable|integer|exists:categories,id',
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|nullable|string|regex:/^[a-z0-9_\-\/]*$/|max:255|unique:categories,slug,' . $this->route('category'),
            'product_name' => 'sometimes|nullable|string|max:255',
            'full_description' => 'sometimes|nullable|string',
            'status' => [
                'sometimes',
                'required',
                new EnumValue(Status::class, false),
            ],
            'is_in_home' => 'sometimes|boolean',
            'is_image_changed' => 'sometimes|boolean',
            'image' => [
                'sometimes',
                'exclude_unless:is_image_changed,true,1',
                'required_unless:parent_id,null',
                'nullable',
                'image',
            ],
            'assigned_by_id' => 'sometimes|nullable|integer',
            'review_ratings' => 'required_unless:parent_id,null|nullable|array|min:4',
            'review_ratings.*' => 'required|array|min:1',
            'review_ratings.*.name' => 'required|string|max:50',
        ];
    }

    public function attributes(): array
    {
        return [
            'review_ratings' => "Критерии",
            'review_ratings.*.name' => "",
        ];
    }

    public function messages(): array
    {
        return [
            'image.required_unless' => 'Поле Изображение обязательно для заполнения, когда Родительская категория заполнена.',
        ];
    }
}
