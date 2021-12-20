<?php

namespace Modules\Review\Http\Requests;

use App\Http\RequestFilters\SanitizesInput;
use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Validator;
use Modules\Review\Enums\ProductReviewExperience;
use Modules\Review\Enums\ProductReviewStatus;
use Modules\Review\Http\PostValidators\ProductReviewUpdateNamePostValidator;

class ProductReviewUpdateRequest extends BaseFormRequest
{
    use SanitizesInput;

    public function filters(): array
    {
        return [
            'status' => 'nullable-cast:integer',
            'is_confirmed' => 'nullable-cast:bool',
        ];
    }

    public function rules(): array
    {
        return [
            'client_id' => 'sometimes|required|int|exists:mysql-crm.clients,id',
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'status' => 'sometimes|required|integer|enum_value:' . ProductReviewStatus::class,
            'is_confirmed' => 'sometimes|required|boolean',
            'experience' => 'sometimes|required|integer|enum_value:' . ProductReviewExperience::class,
            'advantages' => 'sometimes|nullable|string|max:255',
            'disadvantages' => 'sometimes|nullable|string|max:255',
            'comment' => 'sometimes|required|string',
            'ratings' => 'sometimes|required|array|min:1',
            'ratings.*' => 'sometimes|required|int|min:1',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->errors()->isEmpty()) {
                ProductReviewUpdateNamePostValidator::run($validator);
            }
        });
    }
}
