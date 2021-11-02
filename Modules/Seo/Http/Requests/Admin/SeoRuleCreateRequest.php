<?php

namespace Modules\Seo\Http\Requests\Admin;

use App\Http\Requests\BaseFormRequest;
use Modules\Seo\Rules\SeoRuleUrlRouteNotIn;

class SeoRuleCreateRequest extends BaseFormRequest
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
            ],
            'text' => [
                'sometimes',
                'nullable',
                'string',
            ],
            'assigned_by_id' => 'sometimes|nullable|integer',
        ];
    }
}
