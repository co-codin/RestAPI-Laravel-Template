<?php

namespace Modules\Product\Http\Requests\Admin;

use App\Http\RequestFilters\SanitizesInput;
use App\Http\Requests\BaseFormRequest;

class ProductAnswerRequest extends BaseFormRequest
{
    use SanitizesInput;

    public function filters(): array
    {
        return [
            'product_question_id' => 'nullable-cast:integer',
        ];
    }

    public function rules(): array
    {
        return [
            'product_question_id' => 'required|int|exists:product_questions,id',
            'text' => 'required|string',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'person' => 'sometimes|nullable|string|max:255',
            'date' => 'sometimes|nullable|string',
        ];
    }

    public function attributes(): array
    {
        return [
            'product_question_id' => 'Вопрос',
            'text' => 'Текст ответа',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'person' => 'Название лица оставившего ответ',
            'date' => 'Дата создания',
        ];
    }
}
