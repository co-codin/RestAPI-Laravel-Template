<?php

namespace Modules\Product\Http\Requests\Admin;


use Modules\Product\Http\Requests\BaseProductQuestionCreateRequest;

class ProductQuestionCreateRequest extends BaseProductQuestionCreateRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date' => 'required|date',
        ]);
    }
}
