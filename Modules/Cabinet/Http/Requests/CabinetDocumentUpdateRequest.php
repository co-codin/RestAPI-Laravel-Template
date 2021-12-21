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
            'documents.*.name' => 'required|string|max:255',
            'documents.*.docs' => 'required|array',
            'documents.*.docs.*.name' => 'required|string|max:255',
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
        ];
    }

    public function attributes()
    {
        return [
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
