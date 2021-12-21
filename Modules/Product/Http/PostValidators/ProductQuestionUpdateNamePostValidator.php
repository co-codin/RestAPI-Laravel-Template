<?php

namespace Modules\Product\Http\PostValidators;

use App\Http\PostValidators\BasePostValidator;

class ProductQuestionUpdateNamePostValidator extends BasePostValidator
{
    protected function check(): void
    {
        $request = $this->getRequest();
        $firstName = $request->input('first_name');
        $lastName = $request->input('last_name');
        $client_id = $request->input('client_id');

        $productQuestionId = (int) $request->route('product_question');

        $productQuestion = \DB::table('product_questions')
                ->where('id', $productQuestionId)
                ->first() ?? abort(404);

        if (!is_null($productQuestion->client_id)) {
            if (!is_null($firstName)) {
                $this->addError('first_name', 'Поле Имя не может быть добавлено, т.к. к отзыву уже привязан клиент');
            }
            if (!is_null($lastName)) {
                $this->addError('last_name', 'Поле Фамилия не может быть добавлено, т.к. к отзыву уже привязан клиент');
            }
        }

        if ((!is_null($firstName) || !is_null($lastName)) && !is_null($client_id)) {
            $this->addError('client_id', 'Вы можете привязать отзыв к существующему клиенту, либо заполнить Имя и Фамилию');
            $this->addError('first_name', 'Вы можете привязать отзыв к существующему клиенту, либо заполнить Имя и Фамилию');
            $this->addError('last_name', 'Вы можете привязать отзыв к существующему клиенту, либо заполнить Имя и Фамилию');
        }
    }
}
