<?php

namespace Modules\Achievement\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class AchievementCreateRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'image' => 'required|image',
            'is_enabled' => 'sometimes|boolean',
        ];
    }
}
