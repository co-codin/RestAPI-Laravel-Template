<?php

namespace Modules\Faq\Http\Requests;

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
            'name' => 'required|string|unique:question_categories,name,' . $this->get('id'),
            'status' => 'required|boolean'
        ];
    }

    protected function passedValidation()
    {
        abort_if(!$this->validated(), Response::HTTP_BAD_REQUEST);
    }
}
