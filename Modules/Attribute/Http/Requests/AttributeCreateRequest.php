<?php

namespace Modules\Attribute\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttributeCreateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|unique:attributes,name',
            'is_default' => 'sometimes|boolean',
        ];
    }
}
