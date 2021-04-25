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
            'name' => 'sometimes|required|string|max:255',
            'code' => 'sometimes|required|string|max:3',
            'rate' => 'sometimes|required|numeric|min:1',
            'is_main' => [
                'sometimes',
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
