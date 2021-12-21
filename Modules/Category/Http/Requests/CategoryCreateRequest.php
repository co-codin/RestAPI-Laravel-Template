<?php

namespace Modules\Category\Http\Requests;

use App\Enums\Status;
use App\Http\RequestFilters\SanitizesInput;
use BenSampo\Enum\Rules\EnumValue;
use App\Http\Requests\BaseFormRequest;

class CategoryCreateRequest extends BaseFormRequest
{
    use SanitizesInput;

    public function filters(): array
    {
        return [
            'parent_id' => 'nullable-cast:int',
            'status' => 'nullable-cast:int',
            'is_in_home' => 'nullable-cast:bool',
            'assigned_by_id' => 'nullable-cast:int',
            'attach_default_filters' => 'nullable-cast:bool',
        ];
    }

    public function rules()
    {
        return [
            'parent_id' => 'sometimes|nullable|integer|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|regex:/^[a-z0-9_\-\/]*$/|unique:categories,slug',
            'product_name' => 'sometimes|nullable|string|max:255',
            'full_description' => 'sometimes|nullable|string',
            'status' => [
                'required',
                new EnumValue(Status::class, false),
            ],
            'is_in_home' => 'sometimes|boolean',
            'image' => [
                'required_unless:parent_id,null',
                'nullable',
                'image',
            ],
            'assigned_by_id' => 'sometimes|nullable|integer',
            'review_ratings' => 'required_unless:parent_id,null|nullable|array|min:4',
            'review_ratings.*' => 'required|array|min:1',
            'review_ratings.*.name' => 'required|string|max:50',
            'attach_default_filters' => 'sometimes|nullable|boolean',
        ];
    }

    public function attributes(): array
    {
        return [
            'review_ratings' => "Критерии",
            'review_ratings.*.name' => "",
        ];
    }
}
