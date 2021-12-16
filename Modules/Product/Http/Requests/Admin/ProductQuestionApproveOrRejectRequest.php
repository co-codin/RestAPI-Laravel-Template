<?php

namespace Modules\Product\Http\Requests\Admin;

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
