<?php

namespace Modules\Currency\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:3',
            'rate' => 'required|numeric|min:1',
            'is_main' => [
                'required',
                'boolean',
                'unique:currencies,is_main,NULL,id,is_main,1'
            ]
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Название',
            'code' => 'Код',
            'rate' => 'Курс',
        ];
    }
}
