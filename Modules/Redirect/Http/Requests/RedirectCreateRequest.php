<?php


namespace Modules\Redirect\Http\Requests;


use App\Http\Requests\BaseFormRequest;

/**
 * Class RedirectCreateRequest
 * @package Modules\Redirect\Http\Requests\Admin
 */
class RedirectCreateRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'source' => 'required|string|max:255|unique:redirects,source',
            'destination' => 'required|string|max:255',
            'code' => 'sometimes|integer|digits:3|in:301,302',
        ];
    }

    public function attributes()
    {
        return [
            'source' => 'Старая ссылка',
            'destination' => 'Новая ссылка',
            'code' => 'Код',
        ];
    }
}
