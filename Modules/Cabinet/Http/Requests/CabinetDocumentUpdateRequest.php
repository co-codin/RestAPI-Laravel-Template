<?php

namespace Modules\Cabinet\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class CabinetDocumentUpdateRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'documents' => 'required|array',
            'documents.*.group_name' => 'required|string|max:255',
            'documents.*.name' => 'required|string|max:255',
            'documents.*.type' => 'required|integer',
            'documents.*.file' => 'required|string',
        ];
    }
}
