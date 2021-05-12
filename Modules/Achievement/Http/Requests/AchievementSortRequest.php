<?php

namespace Modules\Achievement\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class AchievementSortRequest extends BaseFormRequest
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
