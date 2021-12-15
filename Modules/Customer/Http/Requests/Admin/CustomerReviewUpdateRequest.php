<?php


namespace Modules\Customer\Http\Requests\Admin;


use BenSampo\Enum\Rules\EnumValue;
use Modules\Customer\Enums\CustomerType;

class CustomerReviewUpdateRequest extends CustomerReviewRequest
{
    public function rules(): array
    {
        return [
//            'company_name' => 'sometimes|nullable|string|max:255',
//            'product_id' => 'sometimes|nullable|integer|exists:products,id',
            'position' => 'sometimes|required|string|max:255',
            'author' => 'sometimes|required|string|max:255',
            'type' => [
                'sometimes',
                'required',
                'integer',
                new EnumValue(CustomerType::class, false)
            ],
            'video' => 'sometimes|nullable|string|is_youtube_link|max:255',
            'is_review_file_changed' => 'sometimes|boolean',
            'review_file' => 'sometimes|exclude_unless:is_review_file_changed,true,1|required|file',
            'is_in_home' => 'sometimes|boolean',
            'comment' => 'sometimes|required|string',
            'is_logo_changed' => 'sometimes|boolean',
            'logo' => 'sometimes|exclude_unless:is_logo_changed,true,1|required|image',
        ];
    }
}
