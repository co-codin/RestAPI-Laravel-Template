<?php


namespace Modules\Customer\Http\Requests\Admin;


use BenSampo\Enum\Rules\EnumValue;
use Modules\Customer\Enums\CustomerType;

class CustomerReviewUpdateRequest extends CustomerReviewRequest
{
    public function rules(): array
    {
        return [
            'company_name' => 'sometimes|nullable|string|max:255',
            'product_id' => 'sometimes|nullable|integer|exists:products,id',
            'position' => 'sometimes|required|string|max:255',
            'author' => 'sometimes|required|string|max:255',
            'type' => [
                'sometimes',
                'required',
                'integer',
                new EnumValue(CustomerType::class, false)
            ],
            'video' => 'sometimes|nullable|string|is_youtube_link|max:255',
            'review_file' => 'sometimes|nullable|file',
            'is_in_home' => 'sometimes|nullable|boolean',
            'comment' => 'sometimes|required|string',
            'logo' => 'sometimes|exclude_unless:is_image_changed,true|nullable|image',
            'is_image_changed' => 'sometimes|boolean',
        ];
    }
}
