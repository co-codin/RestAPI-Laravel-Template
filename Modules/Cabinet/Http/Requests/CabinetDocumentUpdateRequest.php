<?php

namespace Modules\Cabinet\Http\Requests;

use App\Enums\DocumentSourceEnum;
use App\Enums\DocumentTypeEnum;
use App\Http\Requests\BaseFormRequest;
use BenSampo\Enum\Rules\EnumValue;

class CabinetDocumentUpdateRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'documents' => 'required|array',
            'documents.*.group_name' => 'required|string|max:255',
            'documents.*.name' => 'required|string|max:255',
            'documents.*.type' => [
                'required',
                'integer',
                new EnumValue(DocumentTypeEnum::class, false)
            ],
            'documents.*.source' => [
                'required',
                'integer',
                new EnumValue(DocumentSourceEnum::class, false)
            ],
            'documents.*.file' => 'required_if:documents.*.source,' . DocumentSourceEnum::FILE . '|nullable|file',
            'documents.*.link' => 'required_if:documents.*.source,' . DocumentSourceEnum::LINK . '|nullable|string',
        ];
    }

    public function attributes()
    {
        return [
            'documents' => 'Документы',
            'categories.*.group_name' => 'Название группы',
            'categories.*.name' => 'Название',
            'categories.*.type' => 'Тип',
            'categories.*.source' => 'Источник',
            'categories.*.file' => 'Файл',
            'categories.*.link' => 'Ссылка',
        ];
    }
}
