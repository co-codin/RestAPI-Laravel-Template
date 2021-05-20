<?php

namespace Modules\Seo\Http\Requests\Admin;

use BenSampo\Enum\Rules\EnumValue;
use App\Http\Requests\BaseFormRequest;

class SeoCreateRequest extends BaseFormRequest
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
