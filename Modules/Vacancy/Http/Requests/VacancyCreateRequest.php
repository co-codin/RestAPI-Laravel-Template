<?php

namespace Modules\Vacancy\Http\Requests;

use App\Enums\Status;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class VacancyCreateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|max:255|string',
            'slug' => 'sometimes|regex:/^[a-z0-9_\-]*$/|nullable|string|max:255|string|unique:vacancies,slug',
            'short_description' => 'required|string|max:255',
            'full_description' => 'required',
            'status' => [
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
