<?php

namespace Modules\Review\Http\PostValidators;

use App\Http\PostValidators\BasePostValidator;

class ProductReviewUpdatePostValidator extends BasePostValidator
{
    protected function check(): void
    {
        $request = $this->getRequest();
        $firstName = $request->input('first_name');
        $lastName = $request->input('last_name');

        $productReviewId = (int)$request->route('product_review');

        $productReview = \DB::table('product_reviews')
            ->where('id', $productReviewId)
            ->first();

        if (is_null($productReview)) {
            abort(404);
        }

        if (!is_null($productReview->client_id)) {
            if (!is_null($firstName)) {
                $this->addError('first_name', 'Поле Имя не может быть добавлено, т.к. к отзыву уже привязан клиент');
            }

            if (!is_null($lastName)) {
                $this->addError('last_name', 'Поле Фамилия не может быть добавлено, т.к. к отзыву уже привязан клиент');
            }
        }

        if ((!is_null($firstName) || !is_null($lastName)) && !is_null($request->input('client_id'))) {
            $this->addError('client_id', 'Вы можете привязать отзыв к существующему клиенту, либо заполнить Имя Фамилию');
            $this->addError('first_name', 'Вы можете привязать отзыв к существующему клиенту, либо заполнить Имя Фамилию');
            $this->addError('last_name', 'Вы можете привязать отзыв к существующему клиенту, либо заполнить Имя Фамилию');
        }
    }
}
