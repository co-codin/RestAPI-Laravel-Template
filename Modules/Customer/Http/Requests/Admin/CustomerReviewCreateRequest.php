<?php


namespace Modules\Customer\Http\Requests\Admin;


use Modules\Customer\Enums\CustomerType;

class CustomerReviewCreateRequest extends CustomerReviewRequest
{
    public function rules(): array
    {
        return [
            'company_name' => 'sometimes|nullable|string|max:255',
            'product_id' => 'sometimes|nullable|integer|exists:products,id',
            'post' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'type' => 'required|integer|enum_value:' . CustomerType::class,
            'video' => 'sometimes|nullable|string|is_youtube_link|max:255',
            'review_file' => 'sometimes|nullable|file',
            'is_home' => 'sometimes|nullable|boolean',
            'comment' => 'required|string',
            'logo' => 'sometimes|nullable|image',
        ];
    }
}
