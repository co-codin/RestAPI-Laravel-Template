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
            'product_id' => 'nullable-cast:integer',
            'analog_id' => 'nullable-cast:integer',
        ];
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|int|exists:products,id',
            'analog_id' => 'required|int|exists:products,id',
        ];
    }

    public function attributes(): array
    {
        return [
            'product_id' => 'Товар',
            'analog_id' => 'Аналог',
        ];
    }
}
