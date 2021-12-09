<?php

namespace Modules\Review\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Review\Models\ProductReview;

class NewReviewNotify extends Mailable implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 5;

    public int $backoff = 60;

    public function __construct(private ProductReview $productReview) {}

    public function build()
    {
        return $this
            ->subject("Добавлен новый отзыв")
            ->view('review::mail.new-review-notify', [
                'productReview' => $this->productReview,
            ]);
    }
}
