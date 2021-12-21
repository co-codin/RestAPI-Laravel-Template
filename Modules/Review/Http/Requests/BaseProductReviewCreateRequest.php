<?php

namespace Modules\Review\Http\Requests;

use App\Http\RequestFilters\SanitizesInput;
use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Validator;
use Modules\Review\Enums\ProductReviewExperience;
use Modules\Review\Http\PostValidators\ProductReviewRatingsPostValidator;

abstract class BaseProductReviewCreateRequest extends BaseFormRequest
{
    use SanitizesInput;

    public function filters(): array
    {
        return [
            'product_id' => 'nullable-cast:integer',
            'experience' => 'nullable-cast:integer',
            'ratings.*' => 'nullable-cast:integer',
        ];
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|int|exists:products,id',
            'experience' => 'required|integer|enum_value:' . ProductReviewExperience::class,
            'advantages' => 'sometimes|nullable|string|max:255',
            'disadvantages' => 'sometimes|nullable|string|max:255',
            'comment' => 'required|string',
        ];
    }

    public function attributes(): array
    {
        return [
            'product_id' => 'Товар',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'experience' => 'Опыт использования',
            'advantages' => 'Достоинства',
            'disadvantages' => 'Недостатки',
            'comment' => 'Комментарий',
            'ratings' => 'Оценки',
            'ratings.main' => 'Общая оценка',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->errors()->isEmpty()) {
                ProductReviewRatingsPostValidator::run($validator);
            }
        });
    }
}
