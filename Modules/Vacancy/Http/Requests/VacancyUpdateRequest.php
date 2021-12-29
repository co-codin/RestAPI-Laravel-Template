<?php

namespace Modules\Vacancy\Http\Requests;

use App\Enums\Status;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class VacancyUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'sometimes|required|max:255|string',
            'slug' => 'sometimes|regex:/^[a-z0-9_\-]*$/|nullable|string|max:255|string|unique:vacancies,slug,' . $this->route('vacancy'),
            'short_description' => 'sometimes|required|string',
            'full_description' => 'sometimes|required',
            'status' => [
                'sometimes',
                'required',
                'integer',
                new EnumValue(Status::class, false),
            ],
            'experience' => 'sometimes|nullable|string',
            'timetable' => 'sometimes|nullable|string',
            'occupation' => 'sometimes|nullable|string',
        ];
    }
}
