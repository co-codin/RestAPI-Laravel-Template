<?php


namespace Modules\Redirect\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

/**
 * Class RedirectCreateRequest
 * @package Modules\Redirect\Http\Requests\Admin
 */
class RedirectCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_url' => 'required|string|max:255|unique:redirects,old_url',
            'new_url' => 'required|string|max:255',
            'code' => 'sometimes|integer|digits:3|in:301,302',
        ];
    }

    public function attributes()
    {
        return [
            'old_url' => 'Старая ссылка',
            'new_url' => 'Новая ссылка',
            'code' => 'Код',
        ];
    }
}
