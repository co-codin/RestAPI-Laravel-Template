<?php


namespace Modules\Redirect\Http\Requests;


use App\Http\Requests\BaseFormRequest;

/**
 * Class RedirectCreateRequest
 * @package Modules\Redirect\Http\Requests\Admin
 */
class RedirectUpdateRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'source' => 'sometimes|required|string|max:255|unique:redirects,source,' . $this->route('redirect'),
            'destination' => 'sometimes|required|string|max:255',
            'code' => 'sometimes|integer|digits:3|in:301,302',
            'assigned_by_id' => 'sometimes|nullable|integer',
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
