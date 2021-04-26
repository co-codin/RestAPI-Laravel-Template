<?php

namespace Modules\Product\Http\Requests;

use App\Enums\Status;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'categories' => [
                'sometimes',
                'required',
                'array',
                function ($attribute, $value, $fail) {
                    $isMain = array_column($value, 'is_main');
                    if (count(array_filter($isMain)) > 1) {
                        $fail('is_main should be unique in array.');
                    }
                },
            ],
            'categories.*.id' => 'sometimes｜required|integer|distinct|exists:categories,id',
            'categories.*.is_main' => 'sometimes｜required|boolean',

            'brand_id' => 'required_unless:type,' . Status::ACTIVE,
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|required|string|unique:products,slug',
            'image' => 'sometimes|required|image',
            'short_description' => 'sometimes|nullable|string',
            'full_description' => 'sometimes|nullable|string',
            'warranty' => 'sometimes|nullable|integer',
            'status' => [
                'sometimes',
                'required',
                'integer',
                new EnumValue(Status::class, false),
            ],
            'is_in_home' => 'sometimes|required|boolean',
        ];
    }
}
