<?php

namespace Modules\Review\Http\Requests;

use App\Http\RequestFilters\SanitizesInput;
use App\Http\Requests\BaseFormRequest;
use Modules\Review\Enums\ProductReviewExperience;

class ProductReviewCreateRequest extends BaseFormRequest
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
//            'ratings' => 'required|array|min:4',
            'ratings' => 'required|array|min:1',
            'ratings.*' => 'required|int|min:1',
        ];
    }

    public function attributes(): array
    {
        return [
            'product_id' => 'Товар',
            'experience' => 'Опыт использования',
            'advantages' => 'Достоинства',
            'disadvantages' => 'Недостатки',
            'comment' => 'Комментарий',
            'ratings' => 'Оценки',
        ];
    }
}
