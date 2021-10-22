<?php

namespace Modules\Achievement\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class AchievementUpdateRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'image' => 'sometimes|exclude_unless:is_image_changed,true|nullable|image',
            'is_enabled' => 'sometimes|boolean',
        ];
    }
}
