<?php

namespace Modules\Publication\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PublicationUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'url' => 'sometimes|required|string|max:255|unique:publications,url,' . $this->get('publication'),
            'source' => 'sometimes|required|string|max:255',
            'is_enabled' => 'sometimes|required|boolean',
            'published_at' => 'sometimes|nullable|date_format:d.m.Y',
        ];
    }

    public function attributes()
    {
        return [
            'published_at' => 'Дата публикации',
        ];
    }
}
