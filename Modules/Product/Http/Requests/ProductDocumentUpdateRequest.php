<?php


namespace Modules\Product\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class ProductDocumentUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'documents' => 'required|array',

        ];
    }
}
