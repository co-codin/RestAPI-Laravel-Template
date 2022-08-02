<?php

namespace Modules\Case\Http\Requests;

use App\Enums\Status;
use App\Http\Requests\BaseFormRequest;
use BenSampo\Enum\Rules\EnumValue;

class CaseCreateRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|max:255|regex:/^[a-z0-9_\-]*$/|unique:case_models,slug',
            'city_id' => 'required|integer|exists:cities,id',
            'short_description' => 'required|string',
            'full_description' => 'required|string',
            'summary' => 'required|string|max:255',
            'note' => 'nullable|string|max:255',
            'status' => [
                'required',
                new EnumValue(Status::class, false),
            ],
            'published_at' => 'required|string|max:255',
        ];
    }

    public function attributes()
    {
        return [
            'published_at' => 'Дата поставки',
            'summary' => 'Второй заголовок',
            'note' => 'Заметка',
        ];
    }
}
