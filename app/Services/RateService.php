<?php

namespace App\Services;

use App\Enums\RateStatus;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\ArrayShape;

class RateService
{
    /**
     * @throws \Exception
     */
    #[ArrayShape(['id' => "int", 'status' => "int"])]
    public function changeRate(Model $model, RateStatus $status): array
    {
        $prevStatus = RateStatus::fromValue((int)\request()->offsetGet('prev_status'));

        $model = match ($prevStatus->value) {
            RateStatus::LIKE => $this->like($model, true),
            RateStatus::DISLIKE => $this->dislike($model, true),
            default => $model
        };

        $model = match ($status->value) {
            RateStatus::LIKE => $this->like($model),
            RateStatus::DISLIKE => $this->dislike($model),
            default => $model
        };

        if (!$model->save()) {
            throw new \Exception('Failed to change like/dislike');
        }

        return [
            'id' => $model->id,
            'status' => $status->value,
        ];
    }

    private function like(Model $model, bool $decrement = false): Model
    {
        return $this->change($model, decrement: $decrement);
    }

    private function dislike(Model $model, bool $decrement = false): Model
    {
        return $this->change($model, false, $decrement);
    }

    private function change(Model $model, bool $like = true, bool $decrement = false): Model
    {
        $field = $like ? 'like' : 'dislike';

        if ($decrement) {
            $model->{$field}--;
        } else {
            $model->{$field}++;
        }

        return $model;
    }
}
