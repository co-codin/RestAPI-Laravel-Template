<?php

namespace Modules\Cabinet\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class CabinetCategoryUpdateRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'categories' => 'required|array',
            'categories.*.id' => 'required|integer',
            'categories.*.name' => 'required|string',
            'categories.*.count' => 'required|integer',
            'categories.*.price' => 'sometimes|nullable|numeric',
            'categories.*.position' => 'sometimes|nullable|integer',
        ];
    }
}
