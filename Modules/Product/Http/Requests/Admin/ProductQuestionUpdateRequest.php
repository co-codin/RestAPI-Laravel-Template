<?php

namespace Modules\Product\Http\Requests\Admin;

use App\Http\RequestFilters\SanitizesInput;
use App\Http\Requests\BaseFormRequest;
use Modules\Product\Enums\ProductQuestionStatus;

class ProductQuestionUpdateRequest extends BaseFormRequest
{
    use SanitizesInput;

    public function filters(): array
    {
        return [
            'status' => 'nullable-cast:integer',
        ];
    }

    public function rules(): array
    {
        return [
            'status' => 'required|integer|enum_value:' . ProductQuestionStatus::class,
            'text' => 'sometimes|nullable|string',
            'created_at' => 'sometimes|nullable|string',
        ];
    }
}
