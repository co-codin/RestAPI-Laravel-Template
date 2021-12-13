<?php

namespace App\Http\Requests;

use App\Http\RequestFilters\SanitizesInput;
use App\Enums\RateStatus;

class RateRequest extends BaseFormRequest
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
            'status' => 'required|int|enum_value:' . RateStatus::class,
        ];
    }
}
