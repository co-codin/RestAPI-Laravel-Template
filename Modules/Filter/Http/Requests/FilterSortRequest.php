<?php


namespace Modules\Filter\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class FilterSortRequest extends FormRequest
{
    public function rules()
    {
        return [
            'filters' => 'required|array',
            'filters.*.id' => 'required|distinct|exists:filters,id',
            'filters.*.position' => 'required|distinct|integer|min:0',
        ];
    }

    public function attributes()
    {
        return [
            'filters' => 'Фильтры',
            'filters.*.id' => 'ID фильтра',
            'filters.*.position' => 'Позиция фильтра',
        ];
    }
}
