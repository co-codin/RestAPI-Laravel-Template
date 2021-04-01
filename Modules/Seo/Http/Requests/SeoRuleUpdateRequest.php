<?php

namespace Modules\Seo\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Seo\Rules\SeoRuleUrlRouteNotIn;
use Symfony\Component\HttpFoundation\Response;

class SeoRuleUpdateRequest extends FormRequest
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
        ];
    }

    protected function passedValidation()
    {
        abort_if(!$this->validated(), Response::HTTP_BAD_REQUEST);
    }
}
