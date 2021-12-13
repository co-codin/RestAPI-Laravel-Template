<?php

namespace Modules\Qna\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Qna\Enums\QuestionStatus;
use Modules\Qna\Models\Question;

class ApprovedQuestionClientNotify extends Mailable implements ShouldQueue
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
        private Question $question,
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
        $approvedText = match ($this->question->status) {
            QuestionStatus::APPROVED => 'одобрен',
            QuestionStatus::REJECTED => 'отклонен',
            default => throw new \LogicException(
                'Question status expected - '
                . implode(',', QuestionStatus::getValues())
                . ', got - ' . $this->question->status
            ),
        };

        return $this
            ->from('admin@medeq.ru', 'Medeq')
            ->subject("Ваш вопрос $approvedText")
            ->view('review::mail.question-approve-notify', [
                'question' => $this->question,
                'comment' => $this->comment,
                'approvedText' => $approvedText,
            ]);
    }
}
