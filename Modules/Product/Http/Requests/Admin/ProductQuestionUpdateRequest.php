<?php

namespace Modules\Product\Http\Requests\Admin;

use App\Http\RequestFilters\SanitizesInput;
use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Validator;
use Modules\Product\Enums\ProductQuestionStatus;
use Modules\Product\Http\PostValidators\ProductQuestionUpdateNamePostValidator;

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
            'client_id' => 'sometimes|required|int|exists:mysql-crm.clients,id',
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'status' => 'required|integer|enum_value:' . ProductQuestionStatus::class,
            'text' => 'sometimes|nullable|string',
            'date' => 'sometimes|nullable|string',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->errors()->isEmpty()) {
                ProductQuestionUpdateNamePostValidator::run($validator);
            }
        });
    }
}
