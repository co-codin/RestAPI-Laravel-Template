<?php

namespace Modules\Cabinet\Http\Requests;

use App\Enums\Status;
use App\Http\Requests\BaseFormRequest;
use BenSampo\Enum\Rules\EnumValue;

class CabinetUpdateRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|nullable|string|max:255|regex:/^[a-z0-9_\-]*$/|unique:cabinets,slug,' . $this->route('cabinet'),
            'is_image_changed' => 'sometimes|boolean',
            'image' => 'sometimes|exclude_unless:is_image_changed,true|nullable|image',
            'category_id' => 'sometimes|required|integer|exists:categories,id',
            'full_description' => 'sometimes|required|string',
            'status' => [
                'sometimes',
                'required',
                new EnumValue(Status::class, false),
            ],
        ];
    }
}
