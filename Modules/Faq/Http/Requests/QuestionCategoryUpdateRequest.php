<?php

namespace Modules\Faq\Http\Requests;

use App\Enums\Status;
use BenSampo\Enum\Rules\EnumValue;
use App\Http\Requests\BaseFormRequest;

class QuestionCategoryUpdateRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255|unique:question_categories,name,' . $this->route('question_category'),
            'slug' => 'sometimes|required|string|max:255|unique:question_categories,slug,' . $this->route('question_category'),
            'status' => [
                'sometimes',
                'required',
                new EnumValue(Status::class, false),
            ],
        ];
    }
}
