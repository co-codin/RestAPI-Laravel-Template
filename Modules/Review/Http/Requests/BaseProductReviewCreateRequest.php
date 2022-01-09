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
            'ratings.*.rate' => 'nullable-cast:integer',
        ];
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|int|exists:products,id',
            'experience' => 'required|integer|enum_value:' . ProductReviewExperience::class,
            'advantages' => 'sometimes|nullable|string',
            'disadvantages' => 'sometimes|nullable|string',
            'comment' => 'required|string',
            'ratings' => 'required|array',
            'answered_at' => 'sometimes|nullable|date',
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
            'created_at' => 'Дата написания',
            'answered_at' => 'Дата написания отзыва',
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
