<?php

namespace Modules\Qna\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class ProductQuestionApproveOrRejectRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'comment' => 'required|string',
        ];
    }
}
