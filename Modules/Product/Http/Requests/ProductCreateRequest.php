<?php

namespace Modules\Product\Http\Requests;

use App\Enums\Status;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Product\Enums\DocumentSource;
use Modules\Product\Enums\DocumentType;
use Modules\Product\Rules\CategoryIsMainRule;

class ProductCreateRequest extends FormRequest
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
                'bail',
                'required',
                'array',
                new CategoryIsMainRule,
            ],
            'categories.*.id' => 'required|integer|distinct|exists:categories,id',
            'categories.*.is_main' => 'required|boolean',

//            'brand_id' => 'required_unless:type,' . Status::ACTIVE,
            'brand_id' => 'required|integer|exists:brands,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'image' => 'required|image',
            'short_description' => 'sometimes|nullable|string',
            'full_description' => 'sometimes|nullable|string',
            'warranty' => 'sometimes|nullable|integer',
            'status' => [
                'required',
                'integer',
                new EnumValue(Status::class, false),
            ],
            'is_in_home' => 'required|boolean',

            'documents' => 'sometimes|nullable|array',
            'documents.*.name' => 'required|string|max:255',
            'documents.*.source' => [
                'required',
                'integer',
                new EnumValue(DocumentSource::class, false),
            ],

            'documents.*.file' => [
                'required_if:documents.*.source,' . DocumentSource::FILE,
                'file',
                'exclude_unless:documents.*.source,' . DocumentSource::URL
            ],

            'documents.*.url' => [
                'required_if:documents.*.source,' . DocumentSource::URL,
                'file',
                'exclude_unless:documents.*.url,' . DocumentSource::FILE
            ],

            'documents.*.type' => [
                'required',
                'integer',
                new EnumValue(DocumentType::class, false),
            ],
            'documents.*.position' => 'sometimes|nullable|integer|distinct',
        ];
    }
}
