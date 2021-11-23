<?php

namespace Modules\Publication\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class PublicationUpdateRequest extends BaseFormRequest
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
            'url' => 'sometimes|required|string|max:255|unique:publications,url,' . $this->route('publication'),
            'source' => 'sometimes|required|string|max:255',
            'is_enabled' => 'sometimes|required|boolean',
            'published_at' => 'sometimes|nullable|date',
            'assigned_by_id' => 'sometimes|nullable|integer',
            'logo' => 'sometimes|nullable|image',
            'is_logo_changed' => 'sometimes|boolean',
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
