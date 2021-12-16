<?php

namespace Modules\Review\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Review\Enums\ProductReviewStatus;
use Modules\Review\Models\ProductReview;

class ApprovedProductReviewClientNotify extends Mailable implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 5;

    /**
     * The number of seconds to wait before retrying the job.
     */
    public int $backoff = 60;

    /**
     * Create a new message instance.
     */
    public function __construct(
        private ProductReview $productReview,
        private string $comment
    ) {}

    /**
     * Build the message.
     *
     * @return $this
     * @throws \Exception
     */
    public function build()
    {
        $approvedText = match ($this->productReview->status) {
            ProductReviewStatus::APPROVED => 'одобрен',
            ProductReviewStatus::REJECTED => 'отклонен',
            default => throw new \LogicException(
                'Product Review status expected - '
                . implode(',', ProductReviewStatus::getValues())
                . ', got - ' . $this->productReview->status
            ),
        };

        return $this
            ->from('admin@medeq.ru', 'Medeq')
            ->subject("Ваш отзыв $approvedText")
            ->view('review::mail.product-review-approve-notify', [
                'productReview' => $this->productReview,
                'comment' => $this->comment,
                'approvedText' => $approvedText,
            ]);
    }
}
