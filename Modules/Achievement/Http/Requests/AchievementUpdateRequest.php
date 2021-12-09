<?php

namespace Modules\Achievement\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class AchievementUpdateRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'is_image_changed' => 'sometimes|boolean',
            'image' => 'sometimes|required|image',
            'is_enabled' => 'sometimes|boolean',
        ];
    }
}
