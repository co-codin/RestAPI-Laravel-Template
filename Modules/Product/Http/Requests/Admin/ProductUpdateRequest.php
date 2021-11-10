<?php

namespace Modules\Product\Http\Requests\Admin;

use App\Enums\Status;
use BenSampo\Enum\Rules\EnumValue;
use App\Http\Requests\BaseFormRequest;
use Modules\Product\Enums\DocumentSource;
use Modules\Product\Enums\DocumentType;

class ProductUpdateRequest extends BaseFormRequest
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
            'brand_id' => 'sometimes|integer|exists:brands,id',
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|required|string|max:255|regex:/^[a-z0-9_\-]*$/|unique:products,slug,' . $this->route('product'),
            'is_image_changed' => 'sometimes|boolean',
            'image' => 'sometimes|exclude_unless:is_image_changed,true|required|image',
            'short_description' => 'sometimes|nullable|string',
            'full_description' => 'sometimes|nullable|string',
            'warranty' => 'sometimes|nullable|integer',
            'status' => [
                'sometimes',
                'required',
                'integer',
                new EnumValue(Status::class, false),
                function ($attribute, $value, $fail) {
                    if ($value === Status::ACTIVE && is_null($this->get('full_description')) && is_null($this->get('image'))) {
                        $fail("Вы не можете включить отображение товара, так как не заполнены обязательные поля");
                    }
                }
            ],
            'stock_type_id' => 'sometimes|nullable|integer|exists:field_values,id',
            'is_in_home' => 'sometimes|required|boolean',
            'assigned_by_id' => 'sometimes|nullable|integer',
            'is_booklet_changed' => 'sometimes|boolean',
            'booklet' => 'sometimes|nullable|file',
            'video' => 'sometimes|nullable|string|max:255',
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
            'documents.*.position' => 'sometimes|nullable|integer|distinct',
        ];
    }
}
