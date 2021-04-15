<?php

namespace Modules\Brand\Http\Requests;

use App\Enums\Status;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class BrandUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|nullable|string|max:255|unique:brands,slug,' . $this->route('brand'),
            'status' => [
                'sometimes',
                'required',
                new EnumValue(Status::class, false),
            ],
            'is_in_home' => 'sometimes|boolean',
            'image' => 'sometimes|nullable|image|max:255',
            'country' => 'sometimes|nullable|string|max:255',
            'website' => 'sometimes|nullable|string|url|max:255',
            'short_description' => 'sometimes|nullable|string|max:255',
            'full_description' => 'sometimes|nullable|string|max:255',
            'position' => 'sometimes|nullable|integer',
        ];
    }

    protected function passedValidation()
    {
        abort_if(!$this->validated(), Response::HTTP_BAD_REQUEST);
    }
}
