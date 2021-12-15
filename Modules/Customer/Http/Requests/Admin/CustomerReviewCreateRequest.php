<?php


namespace Modules\Customer\Http\Requests\Admin;


use BenSampo\Enum\Rules\EnumValue;
use Modules\Customer\Enums\CustomerType;

class CustomerReviewCreateRequest extends CustomerReviewRequest
{
    public function rules(): array
    {
        return [
//            'company_name' => 'sometimes|nullable|string|max:255',
//            'product_id' => 'sometimes|nullable|integer|exists:products,id',
            'position' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'type' => [
                'required',
                'integer',
                new EnumValue(CustomerType::class, false)
            ],
            'video' => 'nullable|string|is_youtube_link|max:255',
            'review_file' => 'nullable|file',
            'is_in_home' => 'boolean',
            'comment' => 'required|string',
            'logo' => 'required|image',
        ];
    }
}
