<?php

namespace Modules\Faq\Http\Requests;

use App\Enums\Status;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class QuestionCreateRequest extends FormRequest
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
            'slug' => 'required|string|unique:questions,slug',
            'answer' => 'required|string|max:255',
            'status' => [
                'required',
                new EnumValue(Status::class, false),
            ],
            'question_category_id' => 'required|integer|exists:question_categories,id'
        ];
    }
}
