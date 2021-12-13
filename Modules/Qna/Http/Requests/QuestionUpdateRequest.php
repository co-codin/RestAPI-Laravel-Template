<?php

namespace Modules\Qna\Http\Requests;

use App\Http\RequestFilters\SanitizesInput;
use App\Http\Requests\BaseFormRequest;
use Modules\Qna\Enums\QuestionStatus;

class QuestionUpdateRequest extends BaseFormRequest
{
    use SanitizesInput;

    public function filters(): array
    {
        return [
            'status' => 'nullable-cast:integer',
        ];
    }

    public function rules(): array
    {
        return [
            'status' => 'required|integer|enum_value:' . QuestionStatus::class,
            'text' => 'sometimes|nullable|string',
            'created_at' => 'sometimes|nullable|string',
        ];
    }
}
