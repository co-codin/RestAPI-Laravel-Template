<?php

namespace Modules\Product\Http\Requests\Admin;

use App\Http\RequestFilters\SanitizesInput;
use App\Http\Requests\BaseFormRequest;

class ProductAnalogRequest extends BaseFormRequest
{
    use SanitizesInput;

    public function filters(): array
    {
        return [
            '*.analog_id' => 'nullable-cast:integer',
            '*.position' => 'nullable-cast:integer',
        ];
    }

    public function rules(): array
    {
        return [
            '*.analog_id' => 'required|int|exists:products,id',
            '*.position' => 'required|int|min:1',
        ];
    }

    public function attributes(): array
    {
        return [
            '*.analog_id' => 'Аналог',
            '*.position' => 'Позиция',
        ];
    }
}
