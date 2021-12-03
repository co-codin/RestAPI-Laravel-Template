<?php


namespace Modules\Review\Services;


use Modules\Review\Dto\ProductReviewDto;
use Modules\Review\Enums\ProductReviewStatus;
use Modules\Review\Mail\ApprovedProductReviewClientNotify;
use Modules\Review\Models\ProductReview;

class ProductReviewStorage
{
    /**
     * @throws \Exception
     */
    public function store(ProductReviewDto $productReviewDto): ProductReview
    {
        $productReview = new ProductReview($productReviewDto->toArray());

        if (!$productReview->save()) {
            throw new \Exception('Can not create Product Review');
        }

        return $productReview;
    }

    /**
     * @throws \Exception
     */
    public function update(ProductReview $productReview, ProductReviewDto $productReviewDto): ProductReview
    {
        if (!$productReview->update($productReviewDto->toArray())) {
            throw new \Exception('Can not update Product Review');
        }

        return $productReview;
    }

    /**
     * @throws \Exception
     */
    public function delete(ProductReview $productReview): void
    {
        if (!$productReview->delete()) {
            throw new \Exception('Can not delete Product Review');
        }
    }

    /**
     * @throws \Exception
     */
    public function approve(ProductReview $productReview, string $comment, bool $status = ProductReviewStatus::APPROVED): void
    {
        if (!$productReview->update(['status' => $status])) {
            throw new \Exception('Can not approve/reject Product Review');
        }

        $email = $productReview->client->email;

        if (!is_null($email)) {
            \Mail::to($email)->queue(new ApprovedProductReviewClientNotify($productReview, $comment));
        }
    }
}
