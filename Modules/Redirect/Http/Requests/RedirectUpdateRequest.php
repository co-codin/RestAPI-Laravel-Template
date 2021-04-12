<?php


namespace Modules\Redirect\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

/**
 * Class RedirectCreateRequest
 * @package Modules\Redirect\Http\Requests\Admin
 */
class RedirectUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_url' => 'sometimes|required|string|max:255|unique:redirects,old_url,' . $this->route('redirect'),
            'new_url' => 'sometimes|required|string|max:255',
            'code' => 'sometimes|integer|digits:3|in:301,302',
        ];
    }
}
