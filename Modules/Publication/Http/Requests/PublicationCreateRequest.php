<?php

namespace Modules\Publication\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PublicationCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:255|unique:publications,url',
            'source' => 'required|string',
            'is_enabled' => 'required|boolean',
            'published_at' => 'sometimes|nullable|date_format:d.m.Y',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Заголовок',
            'url' => 'Ссылка',
            'source' => 'Источник',
            'is_enabled' => 'Статус',
            'published_at' => 'Дата публикации',
        ];
    }
}
