<?php

namespace Modules\Case\Http\Requests;

use App\Enums\Status;
use App\Http\Requests\BaseFormRequest;
use BenSampo\Enum\Rules\EnumValue;

class CaseCreateRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'city_id' => 'required|integer|exists:cities,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|max:255|regex:/^[a-z0-9_\-]*$/|unique:cases,slug',
            'short_description' => 'required|string',
            'full_description' => 'required|string',
            'summary' => 'required|string|max:255',
            'note' => 'nullable|string|max:255',
            'status' => [
                'required',
                new EnumValue(Status::class, false),
            ],
            'published_at' => 'required|string|max:255',
            'image' => 'required|string',
            'images' => 'nullable|array',
            'images.*.image' => 'required|string|max:255',
            'images.*.caption' => 'required|string|max:255',
            'released_year' => 'required|int|max:4',
            'released_quarter' => 'required|int|max:1',
        ];
    }

    public function attributes()
    {
        return [
            'published_at' => 'Дата поставки',
            'summary' => 'Что сделано?',
            'note' => 'Заметка',
            'images' => 'Галерея',
            'images.*.image' => 'Изображение',
            'images.*.caption' => 'Подпись к изображению',
            'released_year' => 'Год реализации',
            'released_quarter' => 'Квартал реализации',
        ];
    }
}
