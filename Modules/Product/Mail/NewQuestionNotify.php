<?php

namespace Modules\Product\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Product\Models\ProductQuestion;

class NewQuestionNotify extends Mailable implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 5;

    public int $backoff = 60;

    public function __construct(
        private ProductQuestion $productQuestion
    ) {}

    public function build()
    {
        return $this
            ->subject("Добавлен новый вопрос к товару")
            ->view('product::mail.new-question-notify', [
                'productQuestion' => $this->productQuestion,
            ]);
    }
}
