<?php

namespace Modules\Seo\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Seo\Rules\SeoRuleUrlRouteNotIn;

class SeoRuleCreateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'url' => [
                'required',
                'string',
                'max:255',
                'unique:seo_rules,url',
                new SeoRuleUrlRouteNotIn([
                    'routes' => [
                        'product-view',
                        'amp-product-view',
                        'news-view',
                        'brand-view',
                        'category-root-view',
                        'category-view'
                    ]
                ])
            ],
        ];
    }
}
