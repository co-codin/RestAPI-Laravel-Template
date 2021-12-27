<?php

namespace Modules\Product\Http\Requests\Admin;

use App\Http\RequestFilters\SanitizesInput;
use App\Http\Requests\BaseFormRequest;
use Modules\Product\Enums\Availability;

class VariationLinkRequest extends BaseFormRequest
{
    use SanitizesInput;

    public function filters(): array
    {
        return [
            'product_variation_id' => 'nullable-cast:integer',
            'links.*.is_default' => 'nullable-cast:boolean',
            'links.*.currency_id' => 'nullable-cast:integer',
            'links.*.price' => 'nullable-cast:integer',
            'links.*.availability' => 'nullable-cast:integer',
        ];
    }

    public function rules(): array
    {
        return [
            'product_variation_id' => 'required|int|exists:product_variations,id',
            'links' => 'required|array',
            'links.*' => 'required|array',
            'links.*.supplier' => 'required|string|max:255',
            'links.*.key' => 'required|string|max:255',
            'links.*.is_default' => 'required|boolean',
            'links.*.check' => 'required|array',
            'links.*.check.*' => 'required|array',
            'links.*.check.*.element' => 'required|string',
            'links.*.check.*.value' => 'required|string|max:255',
            'links.*.currency_id' => 'required|int|exists:currencies,id',
            'links.*.price' => 'required|int',
            'links.*.availability' => 'required|int|enum_value:' . Availability::class,
            'links.*.info_updated_at' => 'required|date',
        ];
    }

    public function attributes(): array
    {
        return [
            'product_variation_id' => 'Вариация',
            'links.*.supplier' => 'Поставщик',
            'links.*.key' => 'Ключ',
            'links.*.is_default' => 'По умолчанию',
            'links.*.check' => 'Проверка',
            'links.*.currency_id' => 'Валюта',
            'links.*.price' => 'Цена',
            'links.*.availability' => 'Наличие',
            'links.*.info_updated_at' => 'Дата обновления данных',
        ];
    }
}
