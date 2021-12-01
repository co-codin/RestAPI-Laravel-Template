<?php

namespace Modules\Review\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
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

    private ProductReview $productReview;

    private string $comment;

    /**
     * Create a new message instance.
     *
     * @param ProductReview $productReview
     * @param string $comment
     */
    public function __construct(ProductReview $productReview, string $comment)
    {
        $this->productReview = $productReview;
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $productReview = $this->productReview;
        $approvedText = $productReview->is_confirmed ? 'одобрен' : 'отклонен';

        return $this
            ->from('admin@medeq.ru', 'Medeq')
            ->subject("Ваш отзыв $approvedText")
            ->view('review::mail.product-review-approve-notify', [
                'productReview' => $productReview,
                'comment' => $this->comment,
                'approvedText' => $approvedText,
            ]);
    }
}
