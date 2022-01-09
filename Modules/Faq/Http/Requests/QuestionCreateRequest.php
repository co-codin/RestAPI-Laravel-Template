<?php

namespace Modules\Faq\Http\Requests;

use App\Enums\Status;
use BenSampo\Enum\Rules\EnumValue;
use App\Http\Requests\BaseFormRequest;

class QuestionCreateRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'question' => 'required|string|max:255',
            'slug' => 'sometimes|string|unique:questions,slug|max:255|regex:/^[a-z0-9_\-]*$/',
            'answer' => 'required|string|max:255',
            'status' => [
                'required',
                new EnumValue(Status::class, false),
            ],
            'question_category_id' => 'required|integer|exists:question_categories,id',
        ];
    }

    public function attributes()
    {
        return [
            'question' => 'Вопрос',
            'answer' => 'Ответ',
            'question_category_id' => 'ID категории',
        ];
    }
}
