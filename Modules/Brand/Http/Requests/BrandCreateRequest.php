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
            'slug' => 'sometimes|nullable|string|max:255|unique:brands,slug,' . $this->get('id'),
            'image' => 'nullable|string|max:255',
            'short_description' => 'sometimes|nullable|string',
            'country' => 'sometimes|nullable|string',
            'website' => 'sometimes|nullable|string',
            'benefits' => 'nullable|string',
            'full_description' => 'sometimes|nullable|string|external_links',
            'status' => [
                'required',
                'integer',
                new EnumValue(Status::class),
            ],
            'in_home' => 'sometimes|boolean|',
            'position' => 'sometimes|nullable|integer',
        ];
    }

    public function authorize()
    {
        return auth('api')->check();
    }
}
