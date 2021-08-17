<?php

namespace Modules\Product\Http\Requests\Admin;

use App\Enums\Status;
use BenSampo\Enum\Rules\EnumValue;
use App\Http\Requests\BaseFormRequest;
use Modules\Product\Rules\CategoryIsMainRule;

class ProductCreateRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'categories' => [
                'bail',
                'required',
                'array',
                new CategoryIsMainRule,
            ],
            'categories.*.id' => 'required|integer|distinct|exists:categories,id',
            'categories.*.is_main' => 'required|boolean',
            'brand_id' => 'required|integer|exists:brands,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'image' => 'required|image',
            'short_description' => 'sometimes|nullable|string',
            'full_description' => 'sometimes|nullable|string',
            'warranty' => 'sometimes|nullable|integer',
            'status' => [
                'sometimes',
                'required',
                'integer',
                new EnumValue(Status::class, false),
            ],
            'is_in_home' => 'sometimes|required|boolean',
        ];
    }
}
