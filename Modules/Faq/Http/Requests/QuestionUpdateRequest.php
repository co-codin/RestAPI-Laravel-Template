<?php

namespace Modules\Faq\Http\Requests\Admin;

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
            'question' => 'required|string',
            'slug' => 'required|string|unique:questions,slug,' . $this->route('question'),
            'answer' => 'required|string|max:255',
            'status' => 'required|boolean',
            'question_category_id' => 'required|integer|exists:question_categories,id'
        ];
    }
}
