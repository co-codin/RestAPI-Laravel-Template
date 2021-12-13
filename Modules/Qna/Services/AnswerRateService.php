<?php

namespace Modules\Qna\Services;

use App\Enums\RateStatus;
use Modules\Qna\Models\Answer;

class AnswerRateService
{
    /**
     * @throws \Exception
     */
    public function changeRate(Answer $answer, RateStatus $status): array
    {
        $prevStatus = RateStatus::fromValue((int)\request()->offsetGet('prev_status'));

        $answer = match ($prevStatus->value) {
            RateStatus::LIKE => $this->like($answer, true),
            RateStatus::DISLIKE => $this->dislike($answer, true),
            default => $answer
        };

        $answer = match ($status->value) {
            RateStatus::LIKE => $this->like($answer),
            RateStatus::DISLIKE => $this->dislike($answer),
            default => $answer
        };

        if (!$answer->save()) {
            throw new \Exception('Failed to change like/dislike in answer - ' . $answer->id);
        }

        $newCookie = unserialize(\Cookie::get('qna_rate'));
        $newCookie[$answer->id] = $status->value;

        return $newCookie;
    }

    private function like(Answer $answer, bool $decrement = false): Answer
    {
        return $this->change($answer, decrement: $decrement);
    }

    private function dislike(Answer $answer, bool $decrement = false): Answer
    {
        return $this->change($answer, false, $decrement);
    }

    private function change(Answer $answer, bool $like = true, bool $decrement = false): Answer
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
