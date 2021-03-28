<?php

namespace Modules\Achievement\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AchievementPositionRequest extends FormRequest
{
    public function rules()
    {
        return [
            'positions' => 'required|array',
            'positions.*.id' => 'required|distinct|exists:achievements,id',
            'positions.*.position' => 'required|distinct|integer',
        ];
    }

    public function attributes()
    {
        return [
            'positions' => 'Позиции достижений',
            'positions.*.id' => 'ID достижения',
            'positions.*.position' => 'Позиция достижения',
        ];
    }
}
