<?php


namespace Modules\Customer\Http\Requests\Admin;


use Modules\Customer\Enums\CustomerType;

class CustomerReviewUpdateRequest extends CustomerReviewRequest
{
    public function rules(): array
    {
        return [
            'post' => 'sometimes|required|string|max:255',
            'author' => 'sometimes|required|string|max:255',
            'type' => 'sometimes|required|integer|enum_value:' . CustomerType::class,
            'video' => 'sometimes|nullable|string|is_youtube_link|max:255',
            'review_file' => 'sometimes|nullable|file',
            'is_home' => 'sometimes|nullable|boolean',
            'comment' => 'sometimes|required|string',
            'logo' => 'sometimes|exclude_unless:is_image_changed,true|nullable|image',
            'is_image_changed' => 'sometimes|boolean',
        ];
    }
}
