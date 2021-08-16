<?php

namespace Modules\Category\Http\Requests;

use App\Enums\Status;
use BenSampo\Enum\Rules\EnumValue;
use App\Http\Requests\BaseFormRequest;

class CategoryUpdateRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'parent_id' => 'sometimes|nullable|integer|exists:categories,id',
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|nullable|string|max:255|unique:categories,slug,' . $this->route('category'),
            'product_name' => 'sometimes|nullable|string|max:255',
            'full_description' => 'sometimes|nullable|string|max:255',
            'status' => [
                'sometimes',
                'required',
                new EnumValue(Status::class, false),
            ],
            'is_hidden_in_parents' => 'sometimes|boolean',
            'is_in_home' => 'sometimes|boolean',
            'image' => [
                'sometimes',
                'required_unless:parent_id,null',
                'nullable',
                'image',
            ],
            'assigned_by_id' => 'sometimes|nullable|integer',
        ];
    }
}
