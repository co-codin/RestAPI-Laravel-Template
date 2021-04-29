<?php


namespace Modules\Product\Http\Requests;


use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Product\Enums\DocumentSource;
use Modules\Product\Enums\DocumentType;

class ProductDocumentUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'documents' => 'required|array',
            'documents.*.name' => 'required|string|max:255',
            'documents.*.source' => [
                'required',
                'integer',
                new EnumValue(DocumentSource::class, false),
            ],
            'documents.*.file' => 'required_if:documents.*.source,' . DocumentSource::FILE . '|file',
            'documents.*.url' => 'required_if:documents.*.source,' . DocumentSource::URL,

            'documents.*.type' => [
                'required',
                'integer',
                new EnumValue(DocumentType::class, false),
            ],
            'documents.*.position' => 'sometimes|nullable|integer|distinct',
        ];
    }
}
