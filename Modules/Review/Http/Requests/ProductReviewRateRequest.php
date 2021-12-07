<?php

namespace Modules\Review\Http\Requests;

use App\Http\RequestFilters\SanitizesInput;
use App\Http\Requests\BaseFormRequest;
use Modules\Review\Enums\ProductReviewRateStatus;

class ProductReviewRateRequest extends BaseFormRequest
{
    use SanitizesInput;

    public function filters()
    {
        return [
            'status' => 'nullable-cast:int'
        ];
    }

    public function rules(): array
    {
        return [
            'status' => 'required|int|enum_value:' . ProductReviewRateStatus::class,
        ];
    }
}
