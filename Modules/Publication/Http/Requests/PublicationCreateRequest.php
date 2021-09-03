<?php

namespace Modules\Publication\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class PublicationCreateRequest extends BaseFormRequest
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
            'source' => 'required|string|max:255',
            'is_enabled' => 'required|boolean',
            'published_at' => 'sometimes|nullable|date_format:d.m.Y',
            'assigned_by_id' => 'sometimes|nullable|integer',
            'logo' => 'sometimes|nullable|image',
        ];
    }

    public function attributes()
    {
        return [
            'published_at' => 'Дата публикации',
            'logo' => 'Логотип',
        ];
    }
}
