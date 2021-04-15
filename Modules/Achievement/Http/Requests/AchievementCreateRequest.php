<?php

namespace Modules\Achievement\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AchievementCreateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'image' => 'required|image|max:512',
            'is_enabled' => 'sometimes|boolean',
        ];
    }
}
