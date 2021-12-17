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
            'documents.*.docs.*.name' => 'required|string|max:255',
            'documents.*.docs.*.type' => [
                'required',
                'integer',
                new EnumValue(DocumentTypeEnum::class, false)
            ],
            'documents.*.docs.*.source' => [
                'required',
                'integer',
                new EnumValue(DocumentSourceEnum::class, false)
            ],
            'documents.*.docs.*.file' => 'required_if:documents.*.source,' . DocumentSourceEnum::FILE . '|nullable|file',
            'documents.*.docs.*.link' => 'required_if:documents.*.source,' . DocumentSourceEnum::LINK . '|nullable|string',
            'documents.*.docs.*.position' => 'sometimes|nullable|integer',
        ];
    }

    public function attributes()
    {
        return [
            'documents' => 'Документы',
            'documents.*.document_group_id' => 'ID группы',
            'documents.*.docs.*.name' => 'Название',
            'documents.*.docs.*.type' => 'Тип',
            'documents.*.docs.*.source' => 'Источник',
            'documents.*.docs.*.file' => 'Файл',
            'documents.*.docs.*.link' => 'Ссылка',
            'documents.*.docs.*.position' => 'Позиция',
        ];
    }
}
