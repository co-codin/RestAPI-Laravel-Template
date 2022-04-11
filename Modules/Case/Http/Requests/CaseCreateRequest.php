<?php

namespace Modules\Case\Http\Requests;

use App\Http\Requests\BaseFormRequest;

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
            'city_id' => 'sometimes|required|integer|exists:cities,id',
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'required|max:255|regex:/^[a-z0-9_\-]*$/|unique:cases,slug',
            'short_description' => 'sometimes|required|string',
            'full_description' => 'sometimes|required|string',
            'is_enabled' => 'sometimes|required|boolean',
            'published_at' => 'sometimes|required|date',
            'image' => 'sometimes|required|string',
        ];
    }

    public function attributes()
    {
        return [
            'published_at' => 'Дата публикации',
        ];
    }
}
