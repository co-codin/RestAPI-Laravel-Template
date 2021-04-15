<?php

namespace Modules\Seo\Http\Requests;

use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class SeoUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'is_enabled' => 'required|boolean',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'h1' => 'required|string|max:255',
            'meta_tags' => 'nullable|array',
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
