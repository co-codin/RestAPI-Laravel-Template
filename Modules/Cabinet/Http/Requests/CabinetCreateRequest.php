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
            'category_id' => 'required|integer|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'sometimes|nullable|max:255|regex:/^[a-z0-9_\-]*$/|unique:cabinets,slug',
            'image' => 'required|string',
            'full_description' => 'required|string',
            'welcome_text' => 'sometimes|required|nullable|string',
            'view_num' => 'sometimes|nullable|integer',
            'status' => [
                'required',
                new EnumValue(Status::class, false),
            ],
        ];
    }

    public function attributes()
    {
        return [
            'welcome_text' => 'Приветственный текст',
        ];
    }
}
