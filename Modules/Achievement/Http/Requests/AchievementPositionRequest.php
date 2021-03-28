<?php

namespace Modules\Achievement\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AchievementPositionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
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
