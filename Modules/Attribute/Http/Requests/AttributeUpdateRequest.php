<?php

namespace Modules\Attribute\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttributeUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|unique:attributes,name,' . $this->route('attribute'),
            'is_default' => 'sometimes|boolean',
        ];
    }
}
