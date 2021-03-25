<?php

namespace Modules\Achievement\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AchievementCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'image' => 'required|string|max:255',
            'is_enabled' => 'sometimes|boolean',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Название',
            'image' => 'Ссылка картинки',
            'is_enabled' => 'Статус',
        ];
    }
}
