<?php

namespace Modules\Product\Http\Requests\Admin;


use BenSampo\Enum\Rules\EnumValue;
use Modules\Product\Enums\ProductQuestionStatus;
use Modules\Product\Http\Requests\BaseProductQuestionCreateRequest;

class ProductQuestionCreateRequest extends BaseProductQuestionCreateRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'status' => [
                'required',
                new EnumValue(ProductQuestionStatus::class, false),
            ],
        ]);
    }
}
