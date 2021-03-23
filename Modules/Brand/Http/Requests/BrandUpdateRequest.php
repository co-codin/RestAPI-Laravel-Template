<?php

namespace Modules\Brand\Http\Requests;

use App\Enums\Status;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class BrandUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|nullable|string|max:255|unique:brands,slug,' . $this->get('id'),
            'image' => 'sometimes|nullable|string|max:255',
            'short_description' => 'sometimes|nullable|string',
            'country' => 'sometimes|nullable|string',
            'website' => 'sometimes|nullable|string',
            'benefits' => 'sometimes|nullable|string',
            'full_description' => 'sometimes|nullable|string',
            'status' => [
                'sometimes',
                'required',
                'integer',
                new EnumValue(Status::class, false),
            ],
            'is_in_home' => 'sometimes|boolean',
            'position' => 'sometimes|nullable|integer',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
