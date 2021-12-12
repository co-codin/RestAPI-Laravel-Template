<?php

namespace Modules\Cabinet\Http\Requests;

use App\Enums\Status;
use App\Http\Requests\BaseFormRequest;
use BenSampo\Enum\Rules\EnumValue;

class CabinetCreateRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'sometimes|nullable|max:255|regex:/^[a-z0-9_\-]*$/|unique:cabinets,slug',
            'image' => 'required|image',
            'full_description' => 'required|string',
            'status' => [
                'required',
                new EnumValue(Status::class, false),
            ],
        ];
    }
}
