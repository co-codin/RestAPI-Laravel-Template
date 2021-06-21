<?php

namespace Modules\Product\Http\Requests;

use App\Enums\Status;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Product\Enums\DocumentSource;
use Modules\Product\Enums\DocumentType;

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
            'categories.*.id' => 'required|integer|distinct|exists:categories,id',
            'categories.*.is_main' => 'required|boolean',
            // TODO type
//            'brand_id' => 'sometimes|integer|exists:brands,id|required_unless:type,' . Status::ACTIVE,
            'brand_id' => 'sometimes|integer|exists:brands,id',
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|required|string|max:255|unique:products,slug,' . $this->route('product'),
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

            'documents' => 'sometimes|nullable|array',
            'documents.*.name' => 'required|string|max:255',
            'documents.*.source' => [
                'required',
                'integer',
                new EnumValue(DocumentSource::class, false),
            ],
            'documents.*.file' => 'sometimes|required|exclude_unless:documents.*.source,' . DocumentSource::URL . '|url',
            'documents.*.url' => 'sometimes|required|exclude_unless:documents.*.source,' . DocumentSource::FILE . '|file',

            'documents.*.type' => [
                'required',
                'integer',
                new EnumValue(DocumentType::class, false),
            ],
            'documents.*.position' => 'sometimes|nullable|integer|distinct',
        ];
    }
}
