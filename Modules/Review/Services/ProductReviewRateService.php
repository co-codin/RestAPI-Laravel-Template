<?php

namespace Modules\Review\Services;

use App\Enums\RateStatus;
use Modules\Review\Models\ProductReview;

class ProductReviewRateService
{
    /**
     * @throws \Exception
     */
    public function changeRate(ProductReview $productReview, RateStatus $status): array
    {
        $prevStatus = RateStatus::fromValue((int)\request()->offsetGet('prev_status'));

        $productReview = match ($prevStatus->value) {
            RateStatus::LIKE => $this->like($productReview, true),
            RateStatus::DISLIKE => $this->dislike($productReview, true),
            default => $productReview
        };

        $productReview = match ($status->value) {
            RateStatus::LIKE => $this->like($productReview),
            RateStatus::DISLIKE => $this->dislike($productReview),
            default => $productReview
        };

        if (!$productReview->save()) {
            throw new \Exception('Failed to change like/dislike');
        }

        $newCookie = unserialize(\Cookie::get('product_review_rate'));
        $newCookie[$productReview->id] = $status->value;

        return $newCookie;
    }

    private function like(ProductReview $productReview, bool $decrement = false): ProductReview
    {
        return $this->change($productReview, decrement: $decrement);
    }

    private function dislike(ProductReview $productReview, bool $decrement = false): ProductReview
    {
        return $this->change($productReview, false, $decrement);
    }

    private function change(ProductReview $productReview, bool $like = true, bool $decrement = false): ProductReview
    {
        $field = $like ? 'like' : 'dislike';

        if ($decrement) {
            $productReview->{$field}--;
        } else {
            $productReview->{$field}++;
        }

        return $productReview;
    }
}
