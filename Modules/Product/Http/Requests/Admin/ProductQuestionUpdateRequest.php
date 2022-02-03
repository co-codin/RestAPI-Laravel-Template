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
            'product_id' => 'nullable-cast:integer',
        ];
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|int|exists:products,id',
            'client_id' => 'sometimes|required|int|exists:mysql-crm.clients,id',
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'text' => 'sometimes|nullable|string',
            'date' => 'sometimes|required|date',
            'questioned_at' => 'sometimes|nullable|date',
        ];
    }

    public function attributes(): array
    {
        return [
            'product_id' => 'Товар',
            'client_id' => 'Клиент',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'text' => 'Текст вопрос',
            'date' => 'Дата создания',
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
