<?php

namespace Modules\Achievement\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AchievementCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'image' => 'required|string',
            'is_enabled' => 'sometimes|boolean',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
