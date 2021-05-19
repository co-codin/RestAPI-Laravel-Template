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
            'video' => 'sometimes|nullable|string|max:255',
            'review_file' => 'sometimes|nullable|file',
            'is_home' => 'sometimes|nullable|boolean',
            'comment' => 'sometimes|required|string',
            'logo' => 'sometimes|nullable|image',
        ];
    }
}
