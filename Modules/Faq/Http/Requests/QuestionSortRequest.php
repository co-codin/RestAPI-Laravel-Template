<?php

namespace Modules\Faq\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionSortRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'questions' => 'required|array',
            'questions.*.id' => 'required|distinct|exists:questions,id',
            'questions.*.position' => 'required|distinct|integer|min:0',
        ];
    }
}
