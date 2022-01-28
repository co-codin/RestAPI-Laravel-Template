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
            'is_manually_analogs' => 'nullable-cast:boolean',
            'analogs.*.analog_id' => 'nullable-cast:integer',
            'analogs.*.position' => 'nullable-cast:integer',
        ];
    }

    public function rules(): array
    {
        return [
            'is_manually_analogs' => 'required|boolean',
            'analogs.*.analog_id' => [
                'required',
                'int',
                'distinct',
                function ($attribute, $value, $fail) {
                    if ((int)$this->route('product_id') === $value) {
                        $fail('Товар не может быть аналогом самому себе.');
                    }
                },
                'exists:products,id'
            ],
            'analogs.*.position' => 'required|int|distinct|min:1',
        ];
    }

    public function attributes(): array
    {
        return [
            'is_manually_analogs' => 'Подбор аналогов вручную',
            'analogs.*.analog_id' => 'Аналог',
            'analogs.*.position' => 'Позиция',
        ];
    }
}
