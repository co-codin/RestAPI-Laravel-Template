<?php

namespace Modules\Review\Services;

use Modules\Review\Enums\ProductReviewRateStatus;
use Modules\Review\Models\ProductReview;

class ProductReviewRateService
{
    /**
     * @throws \Exception
     */
    public function changeRate(ProductReview $productReview, ProductReviewRateStatus $status): void
    {
        $prevStatus = ProductReviewRateStatus::fromValue((int)\request()->offsetGet('prev_status'));

        $productReview = match ($prevStatus->value) {
            ProductReviewRateStatus::LIKE => $this->like($productReview, true),
            ProductReviewRateStatus::DISLIKE => $this->dislike($productReview, true),
        };

        $productReview = match ($status->value) {
            ProductReviewRateStatus::LIKE => $this->like($productReview),
            ProductReviewRateStatus::DISLIKE => $this->dislike($productReview),
        };

        if (!$productReview->save()) {
            throw new \Exception('');
        }

        \Cookie::forever('product_review_rate', $status->value);
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
