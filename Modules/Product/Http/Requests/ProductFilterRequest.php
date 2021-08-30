<?php

namespace Modules\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductFilterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'query' => [
                'sometimes',
                'nullable',
                'array',
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
                'max: 50',
            ],
            'sort' => [
                'string',
                'nullable',
                Rule::in(['popular', 'price', '-price']),
            ],
        ];
    }
}
