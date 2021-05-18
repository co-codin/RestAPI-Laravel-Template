<?php

namespace Modules\Faq\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class QuestionCategorySortRequest extends BaseFormRequest
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

    public function attributes()
    {
        return [
            'categories' => 'Категории',
            'categories.*.id' => 'ID категории',
            'categories.*.position' => 'Позиция категории',
        ];
    }
}
