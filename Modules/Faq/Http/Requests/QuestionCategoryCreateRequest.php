<?php

namespace Modules\Faq\Http\Requests;

use App\Enums\Status;
use BenSampo\Enum\Rules\EnumValue;
use App\Http\Requests\BaseFormRequest;

class QuestionCategoryCreateRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:question_categories,name',
            'slug' => 'sometimes|string|max:255|unique:question_categories,slug',
            'status' => [
                'required',
                new EnumValue(Status::class, false),
            ],
        ];
    }
}
