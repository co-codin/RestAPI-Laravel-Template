<?php

namespace Modules\Qna\Http\Requests;

use App\Http\RequestFilters\SanitizesInput;
use App\Http\Requests\BaseFormRequest;

class AnswerRequest extends BaseFormRequest
{
    use SanitizesInput;

    public function filters(): array
    {
        return [
            'question_id' => 'nullable-cast:integer',
        ];
    }

    public function rules(): array
    {
        return [
            'question_id' => 'required|int|exists:question,id',
            'text' => 'required|string',
            'name' => 'required|string|max:255',
            'created_at' => 'sometimes|nullable|string|min:4',
        ];
    }

    public function attributes(): array
    {
        return [
            'question_id' => 'Вопрос',
            'text' => 'Текст ответа',
            'name' => 'Имя и фамилия автора ответа',
            'created_at' => 'Дата создания',
        ];
    }
}
