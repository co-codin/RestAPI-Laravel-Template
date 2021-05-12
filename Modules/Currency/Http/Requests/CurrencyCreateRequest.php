<?php

namespace Modules\Currency\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class CurrencyCreateRequest extends BaseFormRequest
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
            'iso_code' => 'required|string|max:3|unique:currencies,iso_code',
            'rate' => 'sometimes|numeric|min:1',
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
