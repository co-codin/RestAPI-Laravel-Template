<?php

namespace Modules\Faq\Http\Requests;

use App\Enums\Status;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class QuestionUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'question' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|required|string|max:255|unique:questions,slug,' . $this->route('question'),
            'answer' => 'sometimes|required|string|max:255',
            'status' => [
                'sometimes',
                'required',
                new EnumValue(Status::class, false),
            ],
            'question_category_id' => 'sometimes|required|integer|exists:question_categories,id'
        ];
    }
}
