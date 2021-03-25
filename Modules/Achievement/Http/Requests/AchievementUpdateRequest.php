<?php

namespace Modules\Achievement\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class AchievementUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'image' => 'sometimes|required|string|max:255',
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

    protected function passedValidation()
    {
        abort_if(!$this->validated(), Response::HTTP_BAD_REQUEST);
    }
}
