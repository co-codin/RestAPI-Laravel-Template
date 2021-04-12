<?php

namespace Modules\Seo\Http\Requests;

use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class SeoCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'seoable_type' => 'required|string|max:255',
            'seable_id' => 'required|integer',
            'is_enabled' => 'sometimes|boolean',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'h1' => 'required|string|max:255',
            'meta_tags' => 'sometimes|nullable|array',
            'meta_tags.*' => 'required|array',
            'meta_tags.*.name' => 'required|string|max:255',
            'meta_tags.*.content' => 'required|string|max:255',
        ];
    }
}
