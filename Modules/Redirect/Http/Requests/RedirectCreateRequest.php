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
            'old_url' => 'required|string|unique:redirects,old_url, ' . $this->route('redirect') . '|max:255',
            'new_url' => 'required|string|max:255',
            'code' => 'sometimes|nullable|integer|digits:3',
        ];
    }
}
