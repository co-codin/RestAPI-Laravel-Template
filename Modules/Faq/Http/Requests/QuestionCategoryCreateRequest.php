<?php

namespace Modules\Faq\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionCategoryCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|unique:question_categories,name',
            'slug' => 'required|string|unique:question_categories,slug',
            'status' => 'required|boolean'
        ];
    }
}
