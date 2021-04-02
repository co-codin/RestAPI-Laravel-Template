<?php

namespace Modules\Faq\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionCategorySortRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'categories' => 'required|array',
            'categories.*.id' => 'required|distinct|exists:question_categories,id',
            'categories.*.position' => 'required|distinct|integer|min:0',
        ];
    }
}
