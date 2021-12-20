<?php

namespace Modules\Review\Http\Requests\Admin;

use Modules\Review\Http\Requests\BaseProductReviewCreateRequest;

class ProductReviewCreateRequest extends BaseProductReviewCreateRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        ]);
    }
}
