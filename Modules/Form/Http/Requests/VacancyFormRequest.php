<?php

namespace Modules\Form\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class VacancyFormRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'vacancy_id' => 'required',
            'vacancy_slug' => 'required',
            'vacancy_name' => 'required|string',
            'about' => 'required|string',
            'files' => 'required|array',
        ];
    }

    public function attributes()
    {
        return [
            'about' => 'Описание',
            'files' => 'Файлы',
        ];
    }
}
