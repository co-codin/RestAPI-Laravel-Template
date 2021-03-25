<?php

namespace Modules\Brand\Http\Requests;

use App\Enums\Status;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class BrandCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'sometimes|nullable|max:255|unique:brands,slug',
            'status' => [
                'required',
                new EnumValue(Status::class, false),
            ],
            'is_in_home' => 'sometimes|boolean',
            'image' => 'nullable|string|max:255',
            'country' => 'sometimes|nullable|string|max:255',
            'website' => 'sometimes|nullable|string|max:255',
            'short_description' => 'sometimes|nullable|string|max:255',
            'full_description' => 'sometimes|nullable|string',
            'position' => 'sometimes|nullable|integer',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Название',
            'slug' => 'Ссылка',
            'status' => 'Статус',
            'is_in_home' => 'Отображать на главной',
            'image' => 'Ссылка на логотип',
            'website' => 'Сайт',
            'country' => 'Страна',
            'short_description' => 'Краткое описание',
            'full_description' => 'Подробное описание',
            'position' => 'Позиция',
        ];
    }
}
