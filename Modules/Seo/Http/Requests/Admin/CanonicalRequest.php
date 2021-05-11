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
            'title' => 'required|string|max:255',
            'url' => [
                'required',
                'string',
                'max:255',
                'unique:canonicals,url,' . $this->route('canonical.id'),
            ],
            'canonical' => 'required|string|max:255',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Заголовок',
            'url' => 'url',
            'text' => 'Seo текст',
        ];
    }

    public function messages()
    {
        return [
            'url.unique' => 'Сео правило с таким url уже существует.',
            'required' => 'Поле :attribute обязательно для заполнения.',
            'string' => 'Поле :attribute должно быть строкой.',
            'max:255' => 'Поле :attribute не может быть длиннее 255 символов.',
        ];
    }
}
