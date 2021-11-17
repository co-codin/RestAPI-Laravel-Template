<?php

namespace Modules\Category\Http\Requests;

use App\Enums\Status;
use BenSampo\Enum\Rules\EnumValue;
use App\Http\Requests\BaseFormRequest;

class CategoryCreateRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'parent_id' => 'sometimes|nullable|integer|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|regex:/^[a-z0-9_\-]*$/|unique:categories,slug',
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
            'attach_default_filters' => 'sometimes|nullable|boolean',
        ];
    }
}
