<?php

namespace Modules\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductFilterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'defaultFilters' => [
                'sometimes',
                'nullable',
                'array',
            ],
            'defaultFilters.*.key' => [
                'required',
                'string',
                'distinct',
                Rule::in([
                    'is_available',
                    'is_hot',
                    'is_active',
                    'has_active_variation',
                    'is_price_visible',
                    'brand.country',
                    'brand.id',
                    'category.id',
                    'categories.id',
                ]),
            ],
            'defaultFilters.*.value' => [
                'required',
            ],
            'filters' => [
                'array',
                'nullable',
            ],
            'filters.*.key' => [
                'required',
                'integer',
                'distinct',
                'exists:filters,id',
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
