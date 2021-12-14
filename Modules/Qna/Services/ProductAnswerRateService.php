<?php

namespace Modules\Qna\Services;

use App\Enums\RateStatus;
use Modules\Qna\Models\ProductAnswer;

class ProductAnswerRateService
{
    /**
     * @throws \Exception
     */
    public function changeRate(ProductAnswer $productAnswer, RateStatus $status): array
    {
        $prevStatus = RateStatus::fromValue((int)\request()->offsetGet('prev_status'));

        $productAnswer = match ($prevStatus->value) {
            RateStatus::LIKE => $this->like($productAnswer, true),
            RateStatus::DISLIKE => $this->dislike($productAnswer, true),
            default => $productAnswer
        };

        $productAnswer = match ($status->value) {
            RateStatus::LIKE => $this->like($productAnswer),
            RateStatus::DISLIKE => $this->dislike($productAnswer),
            default => $productAnswer
        };

        if (!$productAnswer->save()) {
            throw new \Exception('Failed to change like/dislike in product answer - ' . $productAnswer->id);
        }

        $newCookie = unserialize(\Cookie::get('product_answer_rate'));
        $newCookie[$productAnswer->id] = $status->value;

        return $newCookie;
    }

    private function like(ProductAnswer $answer, bool $decrement = false): ProductAnswer
    {
        return $this->change($answer, decrement: $decrement);
    }

    private function dislike(ProductAnswer $answer, bool $decrement = false): ProductAnswer
    {
        return $this->change($answer, false, $decrement);
    }

    private function change(ProductAnswer $answer, bool $like = true, bool $decrement = false): ProductAnswer
    {
        $field = $like ? 'like' : 'dislike';

        if ($decrement) {
            $answer->{$field}--;
        } else {
            $answer->{$field}++;
        }

        return $answer;
    }
}
