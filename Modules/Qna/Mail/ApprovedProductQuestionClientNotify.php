<?php

namespace Modules\Qna\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Qna\Enums\ProductQuestionStatus;
use Modules\Qna\Models\ProductQuestion;

class ApprovedProductQuestionClientNotify extends Mailable implements ShouldQueue
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
        private ProductQuestion $productQuestion,
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
        $approvedText = match ($this->productQuestion->status) {
            ProductQuestionStatus::APPROVED => 'одобрен',
            ProductQuestionStatus::REJECTED => 'отклонен',
            default => throw new \LogicException(
                'Product Question status expected - '
                . implode(',', ProductQuestionStatus::getValues())
                . ', got - ' . $this->productQuestion->status
            ),
        };

        return $this
            ->from('admin@medeq.ru', 'Medeq')
            ->subject("Ваш вопрос $approvedText")
            ->view('review::mail.product-question-approve-notify', [
                'productQuestion' => $this->productQuestion,
                'comment' => $this->comment,
                'approvedText' => $approvedText,
            ]);
    }
}
