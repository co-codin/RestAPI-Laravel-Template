<?php

namespace Modules\Seo\Http\Requests\Admin;

use App\Http\Requests\BaseFormRequest;
use Modules\Seo\Rules\SeoRuleUrlRouteNotIn;

class SeoRuleUpdateRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'url' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                'unique:seo_rules,url,' . $this->route('seo_rule'),
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
            'assigned_by_id' => 'sometimes|nullable|integer',
        ];
    }
}
