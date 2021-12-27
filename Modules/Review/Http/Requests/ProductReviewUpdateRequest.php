<?php

namespace Modules\Review\Http\Requests;

use App\Http\RequestFilters\SanitizesInput;
use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Validator;
use Modules\Review\Enums\ProductReviewExperience;
use Modules\Review\Http\PostValidators\ProductReviewRatingsPostValidator;
use Modules\Review\Http\PostValidators\ProductReviewUpdateNamePostValidator;

class ProductReviewUpdateRequest extends BaseFormRequest
{
    use SanitizesInput;

    public function filters(): array
    {
        return [
            'product_id' => 'nullable-cast:integer',
            'is_confirmed' => 'nullable-cast:bool',
        ];
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|int|exists:products,id',
            'client_id' => 'sometimes|required|int|exists:mysql-crm.clients,id',
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'is_confirmed' => 'sometimes|required|boolean',
            'experience' => 'sometimes|required|integer|enum_value:' . ProductReviewExperience::class,
            'advantages' => 'sometimes|nullable|string',
            'disadvantages' => 'sometimes|nullable|string',
            'comment' => 'sometimes|required|string',
            'ratings' => 'sometimes|required|array|min:1',
            'ratings.*' => 'sometimes|required|int|min:1',
            'created_at' => 'required|date',
        ];
    }

    public function attributes(): array
    {
        return [
            'product_id' => 'Товар',
            'client_id' => 'Клиент',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'is_confirmed' => 'Подтвержден/Не Подтвержден',
            'experience' => 'Опыт использования',
            'advantages' => 'Достоинства',
            'disadvantages' => 'Недостатки',
            'comment' => 'Комментарий',
            'ratings' => 'Оценки',
            'created_at' => 'Дата написания',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->errors()->isEmpty()) {
                ProductReviewUpdateNamePostValidator::run($validator);
                ProductReviewRatingsPostValidator::run($validator);
            }
        });
    }
}
