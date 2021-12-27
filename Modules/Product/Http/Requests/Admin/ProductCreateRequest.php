<?php

namespace Modules\Product\Http\Requests\Admin;

use App\Enums\Status;
use BenSampo\Enum\Rules\EnumValue;
use App\Http\Requests\BaseFormRequest;
use Modules\Product\Enums\DocumentSource;
use Modules\Product\Enums\DocumentType;
use Modules\Product\Enums\ProductGroup;
use Modules\Product\Rules\CategoryIsMainRule;

class ProductCreateRequest extends BaseFormRequest
{
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
            'brand_id' => 'required|integer|exists:brands,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug|regex:/^[a-z0-9_\-]*$/',
            'image' => 'sometimes|nullable|image',
            'booklet' => 'sometimes|nullable|file',
            'video' => 'nullable|string|max:255',
            'short_description' => 'sometimes|nullable|string',
            'full_description' => 'sometimes|nullable|string',
            'warranty' => 'sometimes|nullable|integer',
            'warranty_info' => 'sometimes|nullable|string',
            'stock_type_id' => 'sometimes|nullable|integer|exists:field_values,id',
            'status' => [
                'required',
                'integer',
                new EnumValue(Status::class, false),
                function ($attribute, $value, $fail) {
                    if ($value === Status::ACTIVE && is_null($this->get('full_description')) && is_null($this->get('image'))) {
                        $fail("Вы не можете включить отображение товара, так как не заполнены обязательные поля (Полное описание и главная картинка)");
                    }
                }
            ],
            'is_in_home' => 'sometimes|boolean',
            'assigned_by_id' => 'sometimes|nullable|integer',
            'group_id' => [
                'sometimes',
                'nullable',
                'integer',
                new EnumValue(ProductGroup::class, false),
            ],
            'is_manually_analogs' => 'sometimes|boolean',
            'benefits' => 'sometimes|nullable|array',
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
        ];
    }
}
