<?php

namespace Modules\Review\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class ProductReviewApproveRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'comment' => 'required|string',
        ];
    }
}
