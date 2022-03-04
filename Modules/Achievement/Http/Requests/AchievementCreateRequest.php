<?php

namespace Modules\Achievement\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class AchievementCreateRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'image' => 'required|string',
            'is_enabled' => 'sometimes|boolean',
        ];
    }
}
