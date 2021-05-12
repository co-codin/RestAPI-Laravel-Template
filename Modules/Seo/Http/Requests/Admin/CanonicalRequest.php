<?php


namespace Modules\Seo\Http\Requests\Admin;


use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CanonicalRequest
 * @package Modules\Seo\Http\Requests\Admin
 */
class CanonicalRequest extends FormRequest
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
            'url' => [
                'required',
                'string',
                'max:255',
                'unique:canonicals,url,' . $this->route('canonical.id'),
            ],
            'canonical' => 'required|string|max:255',
        ];
    }
}
