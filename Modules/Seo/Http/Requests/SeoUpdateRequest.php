<?php

namespace Modules\Seo\Http\Requests;

use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SeoUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'is_enabled' => 'required|boolean',
            'title' => 'required_if:is_enabled,1,true|nullable|string|max:255',
            'description' => 'required_if:is_enabled,1,true|nullable|string|max:255',
            'h1' => 'required_if:is_enabled,1,true|nullable|string|max:255',
            'meta_tags' => 'exclude_unless:is_enabled,1|nullable|array',
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
