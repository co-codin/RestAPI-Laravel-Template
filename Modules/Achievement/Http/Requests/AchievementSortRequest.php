<?php

namespace Modules\Achievement\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AchievementSortRequest extends FormRequest
{
    public function rules()
    {
        return [
            'achievements' => 'required|array',
            'achievements.*.id' => 'required|distinct|exists:achievements,id',
            'achievements.*.position' => 'required|distinct|integer|min:0',
        ];
    }

    public function attributes()
    {
        return [
            'achievements' => 'Достижения',
            'achievements.*.id' => 'ID достижения',
            'achievements.*.position' => 'Позиция достижения',
        ];
    }
}
