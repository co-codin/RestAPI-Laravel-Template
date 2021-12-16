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
            'documents.*.document_group_id' => 'required|integer|exists:document_groups,id',
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
            'documents.*.document_group_id' => 'ID группы',
            'documents.*.name' => 'Название',
            'documents.*.type' => 'Тип',
            'documents.*.source' => 'Источник',
            'documents.*.file' => 'Файл',
            'documents.*.link' => 'Ссылка',
        ];
    }
}
