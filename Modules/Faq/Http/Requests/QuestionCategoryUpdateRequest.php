<?php

namespace Modules\Faq\Http\Requests;

use App\Enums\Status;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class QuestionCategoryUpdateRequest extends FormRequest
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
            'slug' => 'sometimes"required|string|unique:question_categories,slug,' . $this->route('question_category'),
            'status' => [
                'sometimes',
                'required',
                new EnumValue(Status::class, false),
            ],
        ];
    }

    protected function passedValidation()
    {
        abort_if(!$this->validated(), Response::HTTP_BAD_REQUEST);
    }
}
