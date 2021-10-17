<?php

namespace Modules\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductFilterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'filters' => [
                'sometimes',
                'array',
            ],
            'filters.*' => [
                'required',
                'array',
            ],
            'filters.*.name' => [
                'required',
                'string',
                'max:200',
            ],
            'filters.*.value' => [
                'required',
            ],
            'filters.*.is_default' => [
                'boolean',
                'nullable',
            ],
            'filters.*.path' => [
                'string',
                'nullable',
                'max:100',
                Rule::in(['variations']),
            ],
            'filters.*.type' => [
                'required',
                'string',
                Rule::in('terms', 'range'),
            ],
            'page' => [
                'sometimes',
                'nullable',
                'array',
            ],
            'page.size' => [
                'nullable',
                'integer',
                'min:1',
                'max:50',
            ],
            'page.number' => [
                'nullable',
                'integer',
                'min: 1',
            ],
//            'sort' => [
//                'string',
//                'nullable',
//                Rule::in(['popular', 'price', '-price']),
//            ],
        ];
    }
}
