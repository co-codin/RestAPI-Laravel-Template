<?php

namespace Modules\Brand\Http\Requests;

use App\Enums\Status;
use BenSampo\Enum\Rules\EnumValue;
use App\Http\Requests\BaseFormRequest;

class BrandCreateRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'sometimes|nullable|max:255|regex:/^[a-z0-9_\-]*$/|unique:brands,slug',
            'status' => [
                'required',
                new EnumValue(Status::class, false),
            ],
            'is_in_home' => 'sometimes|boolean',
            'image' => 'nullable|image',
            'country' => 'sometimes|nullable|string|max:255',
            'website' => 'sometimes|nullable|url|string|max:255',
            'short_description' => 'sometimes|nullable|string',
            'full_description' => 'sometimes|nullable|string',
            'position' => 'sometimes|nullable|integer',
            'assigned_by_id' => 'sometimes|nullable|integer',
            'warranty' => 'required|integer',
        ];
    }
}
