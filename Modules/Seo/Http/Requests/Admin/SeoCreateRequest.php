<?php

namespace Modules\Seo\Http\Requests\Admin;

use App\Http\Requests\BaseFormRequest;

class SeoCreateRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'seoable_type' => 'required|string|max:255',
            'seable_id' => 'required|integer',
            'is_enabled' => 'sometimes|boolean',
            'title' => 'required|string',
            'description' => 'required|string',
            'h1' => 'required|string',
            'meta_tags' => 'sometimes|nullable|array',
            'meta_tags.*' => 'required|array',
            'meta_tags.*.name' => 'required|string|max:255',
            'meta_tags.*.content' => 'required|string|max:255',
        ];
    }

    public function attributes()
    {
        return [
            'h1' => 'h1',
            'meta_tags' => 'Мета тэги',
            'meta_tags.*.title' => 'Название',
            'meta_tags.*.content' => 'Контент',
        ];
    }
}
