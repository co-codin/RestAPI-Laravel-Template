<?php

namespace Modules\Attribute\Http\Requests\Admin;

use App\Http\Requests\BaseFormRequest;

class AttributeCreateRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|unique:attributes,name',
            'is_default' => 'sometimes|boolean',
            'assigned_by_id' => 'sometimes|nullable|integer',
        ];
    }
}
