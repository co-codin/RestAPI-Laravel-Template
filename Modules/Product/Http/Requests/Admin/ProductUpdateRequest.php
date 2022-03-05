<?php

namespace Modules\Product\Http\Requests\Admin;

use App\Enums\DocumentSourceEnum;
use App\Enums\DocumentTypeEnum;
use App\Enums\Status;
use BenSampo\Enum\Rules\EnumValue;
use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;
use Modules\Product\Enums\ProductGroup;
use Modules\Product\Rules\CategoryIsMainRule;
use Modules\Product\Rules\ProductStatusRule;

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
                new CategoryIsMainRule,
            ],
            'categories.*.id' => 'required|integer|distinct|exists:categories,id',
            'categories.*.is_main' => 'required|boolean',
            'brand_id' => 'sometimes|integer|exists:brands,id',
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|required|string|max:255|regex:/^[a-z0-9_\-]*$/|unique:products,slug,' . $this->route('product'),
            'has_test_drive' => 'sometimes|boolean',
            'image' => 'sometimes|required|string',
            'short_description' => 'sometimes|nullable|string',
            'full_description' => 'sometimes|nullable|string',
            'warranty' => 'sometimes|nullable|integer',
            'warranty_info' => 'sometimes|nullable|string',
            'is_arbitrary_warranty' => 'sometimes|boolean',
            'arbitrary_warranty_info' => 'sometimes|nullable|string',
            'status' => [
                'sometimes',
                'required',
                'integer',
                new EnumValue(Status::class, false),
//                new ProductStatusRule,
            ],
            'stock_type_id' => 'sometimes|nullable|integer|exists:field_values,id',
            'is_in_home' => 'sometimes|required|boolean',
            'assigned_by_id' => 'sometimes|nullable|integer',
            'group_id' => [
//                'required_if:status,' . Status::ACTIVE,
                'nullable',
                'integer',
                new EnumValue(ProductGroup::class, false),
            ],
            'booklet' => 'sometimes|nullable|file',
            'video' => 'sometimes|nullable|string|max:255',

            'documents' => 'sometimes|nullable|array',
            'documents.*.name' => [
                'required',
                'string',
                'max:255',
                Rule::in(['Техническая документация', 'Сертификаты']),
            ],
            'documents.*.docs' => 'required|array',
            'documents.*.docs.*.name' => 'nullable|string|max:255',
            'documents.*.docs.*.source' => [
                'required',
                'integer',
                new EnumValue(DocumentSourceEnum::class, false)
            ],
            'documents.*.docs.*.type' => [
                'required',
                'integer',
                new EnumValue(DocumentTypeEnum::class, false)
            ],
            'documents.*.docs.*.file' => 'exclude_unless:documents.*.docs.*.source,' . DocumentSourceEnum::FILE . '|required|string|max:255',
            'documents.*.docs.*.link' => 'exclude_unless:documents.*.docs.*.source,' . DocumentSourceEnum::LINK . '|required|url|max:255',

            'is_manually_analogs' => 'sometimes|boolean',

            'benefits' => 'sometimes|nullable|array',
            'benefits.information' => 'sometimes|nullable|array|max:2',
            'benefits.information.*.icon' => 'required|string|max:255',
            'benefits.information.*.description' => 'required|string|max:255',
            'benefits.chips' => 'sometimes|nullable|array|max:3',
            'benefits.chips.*.value' => 'required|string|max:5',
            'benefits.chips.*.description' => 'required|string|max:255',
            'benefits.benefit' => 'string|nullable|max:500',
        ];
    }

    public function attributes()
    {
        return [
            'benefits' => 'Особенности',
            'benefits.information' => 'Сводная информация',
            'benefits.information.*.icon' => 'Иконка',
            'benefits.information.*.description' => 'Описание',
            'benefits.chips' => 'Фишки',
            'benefits.chips.*.value' => 'Значение',
            'benefits.chips.*.description' => 'Описание',
            'benefits.benefit' => 'Особенность',
            'documents' => 'Документы',
            'documents.*.name' => 'Название группы',
            'documents.*.docs.*.name' => 'Название',
            'documents.*.docs.*.source' => 'Источник',
            'documents.*.docs.*.type' => 'Тип',
            'documents.*.docs.*.file' => 'Файл',
            'documents.*.docs.*.link' => 'Ссылка',
        ];
    }
}
