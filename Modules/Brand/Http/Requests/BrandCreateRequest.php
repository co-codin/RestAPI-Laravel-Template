<?php

namespace Modules\Brand\Http\Requests;

use App\Enums\Status;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class BrandCreateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'sometimes|nullable|max:255|unique:brands,slug',
            'status' => [
                'required',
                new EnumValue(Status::class, false),
            ],
            'is_in_home' => 'sometimes|boolean',
            'image' => 'nullable|image|max:512',
            'country' => 'sometimes|nullable|string|max:255',
            'website' => 'sometimes|nullable|string|max:255',
            'short_description' => 'sometimes|nullable|string|max:255',
            'full_description' => 'sometimes|nullable|string|max:255',
            'position' => 'sometimes|nullable|integer',
        ];
    }
}
