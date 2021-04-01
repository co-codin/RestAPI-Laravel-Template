<?php

namespace Modules\Seo\Http\Requests;

use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Seo\Enums\SeoType;

class SeoUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'is_enabled' => 'required|boolean',
            'title' => 'required|string|max:1000',
            'description' => 'required|string|max:1000',
            'h1' => 'required|string|max:255',
            'meta_tags' => 'sometimes|nullable|array',
            'meta_tags.*' => 'required|array',
            'meta_tags.*.name' => 'required|string|max:255',
            'meta_tags.*.content' => 'required|string|max:255',
            'type' => [
                'required',
                new EnumValue(SeoType::class, false),
            ],
        ];
    }
}
